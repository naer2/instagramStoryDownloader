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

        return $this->ig->request('insights/account_organic_insights/')
            ->addParam('show_promotions_in_landing_page', 'true')
            ->addParam('first', $day)
            ->getResponse(new Response\InsightsResponse());
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
        return $this->ig->request("insights/media_organic_insights/{$mediaId}/")
            ->addParam('ig_sig_key_version', Constants::SIG_KEY_VERSION)
            ->getResponse(new Response\MediaInsightsResponse());
    }

    /**
     * Get account statistics.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GraphqlBatchResponse
     */
    public function getStatistics()
    {
        return $this->ig->request('ads/graphqlbatch/')
            ->setSignedPost(false)
            ->setIsMultiResponse(true)
            ->addParam('locale', Constants::USER_AGENT_LOCALE)
            ->addParam('vc_policy', 'insights_policy')
            ->addPost('access_token', 'undefined')
            ->addPost('batch_name', 'IgInsightsAppRoute')
            ->addPost('fb_api_caller_class', 'RelayClassic')
            ->addPost('method', 'GET')
            ->addPost('queries', json_encode([
                'q0' => [
                    'priority' => 0,
                    'q'        => 'Query IgInsightsAppRoute
                {shadow_instagram_user(\{"id":"'.$this->ig->account_id.'"\,"access_token":""\})
                {id,@F7}} QueryFragment F0 : InstagramBusinessManagerAccountSummaryUnit
                {followers_count,followers_delta_from_last_week,posts_count,posts_delta_from_last_week}
                QueryFragment F1 : InstagramBusinessManagerAccountUnit
                {last_week_impressions,week_over_week_impressions,last_week_reach,week_over_week_reach,last_week_profile_visits,week_over_week_profile_visits,last_week_website_visits,week_over_week_website_visits,last_week_call,week_over_week_call,last_week_text,week_over_week_text,last_week_email,week_over_week_email,last_week_get_direction,week_over_week_get_direction,average_engagement_count}
                QueryFragment F2 : InstagramBusinessManagerAccountUnit
                {last_week_impressions,week_over_week_impressions,last_week_reach,week_over_week_reach,last_week_profile_visits,week_over_week_profile_visits,last_week_website_visits,week_over_week_website_visits,last_week_call,week_over_week_call,last_week_text,week_over_week_text,last_week_email,week_over_week_email,last_week_get_direction,week_over_week_get_direction,average_engagement_count,last_week_impressions_day_graph
                {data_points {label,value}},last_week_reach_day_graph {data_points
                {label,value}},last_week_profile_visits_day_graph {data_points
                {label,value}}} QueryFragment F3 : InstagramBusinessManagerTopPostsUnit
                {summary_posts.first(6) as _summary_poststYGwD {edges {node {image
                {uri},instagram_media_id,instagram_media_type,id},cursor},page_info
                {has_next_page,has_previous_page}}} QueryFragment F4 :
                InstagramBusinessManagerStoriesUnit {state,summary_stories.first(6) as
                _summary_storiesjmsA2 {count,edges {node {image
                {uri,width,height},comment_count,engagement,exits_count,impression_count,instagram_media_id,like_count,reach_count,replies_count,save_count,taps_back_count,taps_forward_count,video_view_count,id},cursor},page_info
                {has_next_page,has_previous_page}}} QueryFragment F5 :
                InstagramBusinessManagerFollowersUnit
                {followers_unit_state,today_hourly_graph.timezone(Europe/Vienna) as
                _today_hourly_graph2Iuh8n {data_points {label,value}},gender_graph
                {data_points {label,value}},all_followers_age_graph {data_points
                {label,value}},followers_top_cities_graph {data_points {label,value}}}
                QueryFragment F6 : InstagramBusinessManagerPromotionsUnit
                {summary_promotions.first(6) as _summary_promotions2ubm1F {edges {node
                {instagram_media_id,instagram_media_type,image
                {uri},impression_count,reach_count,engagement,id},cursor},page_info
                {has_next_page,has_previous_page}}} QueryFragment F7 : InstagramUserV2
                {username,profile_picture {uri},business_manager {promotions_unit
                {summary_promotions.first(6) as _summary_promotions2ubm1F {edges {node
                {instagram_media_id,id},cursor},page_info
                {has_next_page,has_previous_page}}},account_insights_unit
                {last_week_website_visits,week_over_week_website_visits,last_week_call,week_over_week_call,last_week_text,week_over_week_text,last_week_email,week_over_week_email,last_week_get_direction,week_over_week_get_direction,last_week_impressions_day_graph
                {data_points {label}},last_week_reach_day_graph {data_points
                {label}},last_week_profile_visits_day_graph {data_points
                {label}}},feed.enable_account_summary_unit(true) as _feed2py0Z1
                {units.first(6) as _unitsgGaCa {edges {node
                {__typename,@F0,@F1,@F2,@F3,@F4,@F5,@F6},cursor},page_info
                {has_next_page,has_previous_page}}}},id}',
                'query_params' => new \stdClass(),
                ],
            ]))
            ->addPost('response_format', 'json')
            ->addPost('scheduler', 'phased')
            ->getResponse(new Response\GraphqlBatchResponse());
    }
}
