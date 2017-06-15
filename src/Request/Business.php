<?php

namespace InstagramAPI\Request;

use InstagramAPI\Constants;
use InstagramAPI\Response;

/**
 * Business-account related functions.
 *
 * These only work if you have a Business account.
 */
class Business extends RequestCollection
{
    /**
     * Get insights.
     *
     * @param $day
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\InsightsResponse
     */
    public function getInsights(
        $day = null)
    {
        if (empty($day)) {
            $day = date('d');
        }
        $request = $this->ig->request('insights/account_organic_insights/')
            ->addParam('show_promotions_in_landing_page', 'true')
            ->addParam('first', $day);

        return $request->getResponse(new Response\InsightsResponse());
    }

    /**
     * Get media insights.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MediaInsightsResponse
     */
    public function getMediaInsights(
        $mediaId)
    {
        $request = $this->ig->request("insights/media_organic_insights/{$mediaId}/")
            ->addParam('ig_sig_key_version', Constants::SIG_KEY_VERSION);

        return $request->getResponse(new Response\MediaInsightsResponse());
    }
}
