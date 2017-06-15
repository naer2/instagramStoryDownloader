<?php

namespace InstagramAPI;

/**
 * Bridge between Instagram Client calls, the object mapper & response objects.
 */
class Request
{
    /**
     * The Instagram class instance we belong to.
     *
     * @var \InstagramAPI\Instagram
     */
    protected $_parent;

    /**
     * Which API version to use for this request.
     *
     * @var int
     */
    protected $_apiVersion = 1;

    protected $_url;
    protected $_params = [];
    protected $_posts = [];
    protected $_files = [];
    protected $_headers = [];

    /**
     * Whether this API call needs authorization.
     *
     * On by default since most calls require authorization.
     *
     * @var bool
     */
    protected $_needsAuth = true;

    protected $_signedPost = true;

    public function __construct(
        \InstagramAPI\Instagram $parent,
        $url)
    {
        $this->_parent = $parent;
        $this->_url = $url;

        return $this;
    }

    public function setVersion(
        $apiVersion = 1)
    {
        $this->_apiVersion = $apiVersion;

        return $this;
    }

    public function addParam(
        $key,
        $value)
    {
        if ($value === true) {
            $value = 'true';
        }
        $this->_params[$key] = $value;

        return $this;
    }

    public function addPost(
        $key,
        $value)
    {
        $this->_posts[$key] = $value;

        return $this;
    }

    /**
     * Add an on-disk file to a POST request, which causes this to become a multipart form request.
     *
     * @param string      $key      Form field name.
     * @param string      $filepath Path to a file.
     * @param string|null $filename Filename to use in Content-Disposition header.
     * @param array       $headers  An associative array of headers.
     *
     * @throws \InvalidArgumentException
     *
     * @return self
     */
    public function addFile(
        $key,
        $filepath,
        $filename = null,
        $headers = [])
    {
        // Validate
        if (!is_file($filepath)) {
            throw new \InvalidArgumentException(sprintf('File "%s" does not exist.', $filepath));
        }
        if (!is_readable($filepath)) {
            throw new \InvalidArgumentException(sprintf('File "%s" is not readable.', $filepath));
        }
        // Inherit value from $filepath, if not supplied.
        if ($filename === null) {
            $filename = $filepath;
        }
        $filename = basename($filename);
        // Default headers.
        $headers = $headers + [
            'Content-Type'              => 'application/octet-stream',
            'Content-Transfer-Encoding' => 'binary',
        ];
        $this->_files[$key] = [
            'filepath' => $filepath,
            'filename' => $filename,
            'headers'  => $headers,
        ];

        return $this;
    }

    /**
     * Add raw file data to a POST request, which causes this to become a multipart form request.
     *
     * @param string      $key      Form field name.
     * @param string      $data     File data.
     * @param string|null $filename Filename to use in Content-Disposition header.
     * @param array       $headers  An associative array of headers.
     *
     * @throws \InvalidArgumentException
     *
     * @return self
     */
    public function addFileData(
        $key,
        $data,
        $filename,
        $headers = [])
    {
        $filename = basename($filename);
        // Default headers.
        $headers = $headers + [
                'Content-Type'              => 'application/octet-stream',
                'Content-Transfer-Encoding' => 'binary',
            ];
        $this->_files[$key] = [
            'contents' => $data,
            'filename' => $filename,
            'headers'  => $headers,
        ];

        return $this;
    }

    /**
     * Add custom header to request, overwriting any previous or default value.
     *
     * The custom value will even take precedence over the default headers!
     *
     * WARNING: If this is called multiple times with the same header "key"
     * name, it will only keep the LATEST value given for that specific header.
     * It will NOT keep any of its older values, since you can only have ONE
     * value per header! If you want multiple values in headers that support
     * it, you must manually format them properly and send us the final string,
     * usually by separating the value string entries with a semicolon.
     *
     * @param string $key
     * @param string $value
     *
     * @return self
     */
    public function addHeader(
        $key,
        $value)
    {
        $this->_headers[$key] = $value;

        return $this;
    }

    public function setNeedsAuth(
        $needsAuth = true)
    {
        $this->_needsAuth = $needsAuth;

        return $this;
    }

    public function setSignedPost(
        $signedPost = true)
    {
        $this->_signedPost = $signedPost;

        return $this;
    }

    /**
     * Convert the request's data into its HTTP POST multipart body contents.
     *
     * TODO use \GuzzleHttp\Psr7\MultipartStream
     *
     * @return string
     */
    protected function _getMultipartBody()
    {
        $boundary = Utils::generateMultipartBoundary();
        $this->addHeader('Content-Type', 'multipart/form-data; boundary='.$boundary);
        // Here is a tricky part: all form data (including files) must be ordered by hash code.
        // So we are creating an index for building POST data.
        $index = Utils::reorderByHashCode(array_merge($this->_posts, $this->_files));
        $result = '';
        foreach ($index as $key => $value) {
            $result .= '--'.$boundary."\r\n";
            if (!isset($this->_files[$key])) {
                $result .= 'Content-Disposition: form-data; name="'.$key.'"';
                $result .= "\r\n\r\n".$value."\r\n";
            } else {
                $file = $this->_files[$key];
                if (isset($file['contents'])) {
                    $contents = $file['contents'];
                } else {
                    $contents = file_get_contents($file['filepath']);
                }
                $result .= 'Content-Disposition: form-data; name="'.$key.'"; filename="'.$file['filename']."\"\r\n";
                foreach ($file['headers'] as $headerName => $headerValue) {
                    $result .= $headerName.': '.$headerValue."\r\n";
                }
                $result .= "\r\n".$contents."\r\n";
                unset($contents);
            }
        }
        $result .= '--'.$boundary.'--';

        return $result;
    }

    /**
     * Convert the request's data into its HTTP POST body contents.
     *
     * @return string|null The body string if POST request; otherwise NULL if GET request.
     */
    protected function _getRequestBody()
    {
        if (!count($this->_posts) && !count($this->_files)) {
            return;
        }
        if ($this->_signedPost) {
            $this->_posts = Signatures::signData($this->_posts);
        }
        if (!count($this->_files)) {
            $result = http_build_query(Utils::reorderByHashCode($this->_posts));
        } else {
            $result = $this->_getMultipartBody();
        }

        return $result;
    }

    /**
     * Perform the request and get its response object.
     *
     * @param ResponseInterface|null $baseClass An instance of a class object whose
     *                                          properties to fill with the response,
     *                                          or NULL to get a standard object.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return ResponseInterface|object An instance of baseClass if provided,
     *                                  otherwise a standard PHP object.
     */
    public function getResponse(
        ResponseInterface $baseClass = null)
    {
        // Generate the final endpoint URL, by adding any custom query params.
        if (count($this->_params)) {
            $endpoint = $this->_url
                .(strpos($this->_url, '?') === false ? '?' : '&')
                .http_build_query(Utils::reorderByHashCode($this->_params));
        } else {
            $endpoint = $this->_url;
        }

        /** @var string|null $postData The POST body contents; is NULL if GET request instead. */
        $postData = $this->_getRequestBody();

        // Call the API endpoint and get the response.
        $response = $this->_parent->client->api(
            $this->_apiVersion, $endpoint, $this->_headers,
            $postData, $this->_needsAuth, false
        );

        // Decode to base class if provided, or otherwise return raw object.
        return $baseClass !== null
               ? $this->_parent->client->getMappedResponseObject($baseClass, $response)
               : $response;
    }
}
