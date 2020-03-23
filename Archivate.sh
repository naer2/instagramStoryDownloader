#!/usr/bin/env bash

#writing dates into file
find ./downloaded -daystart -maxdepth 1 -type f ! -mtime -2 -exec stat -c "%y" {} \; | awk '{ print $1; }' | sort -u > test.txt

#reading from this file
while read -r line; do
    # Do what you want to $name
	start_date="$line 00:00:00";
	end_date="$line 23:59:59";
	archive_title=`date --date $line +"%d-%m-%Y"`;
	find ./downloaded -type f \( -iname '*.jpg' -o -iname '*.mp4' \) -newermt "$start_date" -not -newermt "$end_date" -printf "%f\0" | tar -czf ./downloaded/$archive_title.tgz -C ./downloaded --null -T -;
	if tar -tzf ./downloaded/$archive_title.tgz >/dev/null;then
		find ./downloaded -type f -newermt "$start_date" -not -newermt "$end_date" -exec rm {} +;
	fi;
	
	echo "end of checking $archive_title";
done < "test.txt"
