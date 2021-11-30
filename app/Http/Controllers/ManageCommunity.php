<?php

namespace App\Http\Controllers;

use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class ManageCommunity extends Controller
{
    //LoadCommunityPage
    public function LoadCommunityPage($sort = null)
    {
        $data = array();
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        ///sort
        if (empty($sort)) {
            $data['sort'] = 'like_count';
        } else {
            $data['sort'] = $sort;
        }

        ///common header
        $data['currentFile'] = get_page_name();
        $data['user_id'] = session()->get('user_id');
        $data['mobile_view'] = 0;

        $data['page'] = $page;

        if (isset($user_seo) && ($user_seo != "")) {
            $qry = "select user_id,date_added,user_name  from  tbl_users where user_seo='" . $user_seo . "' ";
            $result_image = \App\Models\Songs::GetRawData($qry);
            $data['user_name'] = $result_image[0]->user_name;
            $data['user_profile'] = $result_image[0]->user_id;
            $data['date_added_db'] = $result_image[0]->date_added;
            $data['main_link'] = get_user_detail($data['user_name']) . "-profile-";
        } else {
            $data['user_name'] = session()->get('user_name');
            $data['user_profile'] = session()->get('user_id');
            $data['main_link'] = '';
        }



        ///screen char
        $data['screen_chr'] = 15;
        $data['ipad_chr'] = 15;
        $data['mobile_chr'] = 15;
        $data['screen_rev'] = 15;
        $data['ipad_rev'] = 15;
        $data['mobile_rev'] = 15;

        ///row_artist
        $row_artist = array();
        // $row_artist = \App\Models\Songs::GetRawData("select * from tbl_artists where (artist_seo='" . $data['artist_seo'] . "' and artist_description!='') || id='" . $data['artist_seo'] . "'");
        $row_artist = \App\Models\Songs::GetRawData("select * from tbl_artists");
        if ($row_artist) {
            $data['row_artist'] = (array)$row_artist[0];
        }


        //page View
        $data['title'] = GetTitle();
        return view('our_community', $data);
    }

    ///UpdateCommunityPage
    public function UpdateCommunityPage()
    {
        $user_arr = array();
        $user_arr = GetByWhere('users');
      
        if ($user_arr) {
            foreach ($user_arr as $key => $value) {
                $user_id = $value->user_id;
                $data = array();
                $data['like_count'] = count(GetByWhere('likes', array('like_receive_user' => $user_id,'like_type' => 'profile')));
                $data['post_count'] = count(GetByWhere('comments', array('comment_user_id' => $user_id)));
                $data['review_count'] = count(GetByWhere('reviews', array('review_user_id' => $user_id)));
                UpdateRecord('users', array('user_id' => $user_id), $data);
            }
        }

        $data = array('code' => 'success', 'message' => 'sort record updated!');
        echo json_encode($data);
        die;
    }
}
