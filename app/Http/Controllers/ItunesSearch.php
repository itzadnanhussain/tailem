<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItunesSearch extends Controller
{


    ///Load_Itunes_Cron_File code clear
    public function Load_Itunes_Cron_File()
    {
        ini_set('max_execution_time', 1200);
        error_reporting(0);

        /******************************************************
         * ==========Get Record From Artist Table=============
         ******************************************************/

        // $SQL="select artist_name from tbl_artists where artist_status = 1  order by updated_by_itunes DESC limit 1";
        // $artist	=	\App\Models\Songs::GetRawDataAdmin($SQL);
        // $artist_name= strtolower(StringReplace($artist['artist_name']));
        // echo '<pre>';
        // print_r($artist_name);
        // echo '</pre>';
        // die;
        $artist_name= strtolower(StringReplace('Quis magni voluptate'));
        // echo '<pre>';
        // print_r($artist_name);
        // echo '</pre>';
        // die;

        /******************************************************
        * ==========Get Record From Itunes API=============
        ******************************************************/

        echo $url="https://itunes.apple.com/search?term=".urlencode($artist_name);
        echo "<br>";

        $itunesData=get_data($url);
        $itunesData=json_decode($itunesData);
        // echo '<pre>';
        // print_r($itunesData);
        // echo '</pre>';
        // die;

        //print_r($itunesData);
        $i = 1;
        foreach ($itunesData->results as $key=>$value) {
            $itunes_data=(array)$value;

            if (empty($itunes_data['trackPrice'])) {
                $itunes_data['trackPrice'] = 0.0;
            }
                 
            if ($itunes_data['wrapperType']=='track') {
                echo $i.": ";

                /******************************************************
                * ==========Get Record From Last.fm API=============
                ******************************************************/

                echo $song_url="http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=".strtolower(StringReplace($itunes_data['artistName']))."&track=".strtolower(StringReplace($itunes_data['trackName']))."&api_key=36cd9613641f2d9868a85377850aced5&format=json";
                echo "<br>";
                $song_data=track_get_info($song_url);
                $song_data=json_decode($song_data);

                // echo '<pre>';
                // print_r($song_data);
                // echo '</pre>';
                // die;
              
               
                   
                /******************************************************
                * ==========Update/Add Record To Song Table==========
                ******************************************************/


                /////////// song table data update
                $itunes_data['trackName']=addslashes($itunes_data['trackName']);
                $song_update_data = array();
                $song_update_data['id']=$itunes_data['trackId'];
                $song_update_data['song_title']= remove_spl_char($itunes_data['trackName']);
                $song_update_data['keywords']= remove_spl_char($itunes_data['trackName']);
                $song_update_data['song_seo']=Slug($itunes_data['trackName']);
                $song_update_data['lastfm_url']= remove_spl_char($song_data->track->url);
                   
                ///picture
                $artwork=explode("/", $itunes_data['artworkUrl100']);
                array_pop($artwork);
                $artwork=implode("/", $artwork);
                $artwork.= "/370x370bb.jpg";
    
                $song_update_data['picture']=$artwork;
                $releaseDate=explode("-", $itunes_data['releaseDate']);
                $song_update_data['song_year']=$releaseDate[0];
                $song_update_data['itunes_url']= remove_spl_char($itunes_data['trackViewUrl']);
                $song_update_data['itunes_price']= $itunes_data['trackPrice'];
                $song_update_data['country']= remove_spl_char($itunes_data['country']);
                $song_update_data['currency']=$itunes_data['currency'];
                $song_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                $song_update_data['description']=remove_spl_char($song_data->track->wiki->summary);
                $song_update_data['posted_date'] = time();
                $song_update_data['ranking_order'] = 1;
                // echo '<pre>';
                // print_r($song_update_data);
                // echo '</pre>';
                // die;
                    
                $is_song_added = GetByWhere('songs', array('id'=> $song_update_data['id']));
                if (!empty($is_song_added) && !empty($song_update_data)) {
                    UpdateRecord('songs', array('id'=>$song_update_data['id']), $song_update_data);
                } else {
                    addNew('songs', $song_update_data);
                }


                /******************************************************
                * ==========Add/Update Latest Songs Table=============
                ******************************************************/

                if ($itunes_data['releaseDate']) {
                    // echo $itunes_data['releaseDate'];
                    $song_year =  date('Y', strtotime($itunes_data['releaseDate']));
                    $current_year = date('Y');
                    if ($song_year == $current_year) {
                        $latest_song['id'] =  $song_update_data['id'];
                        $latest_song['song_title'] =  $song_update_data['song_title'];
                        $latest_song['song_seo'] =  $song_update_data['song_seo'];
                        $latest_song['picture'] =  $song_update_data['picture'];
                        $latest_song['updated_by_itunes'] =  $song_update_data['updated_by_itunes'];

                        $is_latest_song_added = GetByWhere('latest_songs', array('id'=> $latest_song['id']));
                        if (!empty($is_latest_song_added) && !empty($latest_song)) {
                            UpdateRecord('latest_songs', array('id'=>$latest_song['id']), $latest_song);
                        } else {
                            addNew('latest_songs', $latest_song);
                        }
                    }
                }

               

                   

                /******************************************************
                * ==========Update/Add Record To Artist Table==========
                ******************************************************/

                ///artist info fetch by last.fm api
                $artist_url="http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=".trim($itunes_data['artistName'])."&api_key=36cd9613641f2d9868a85377850aced5&format=json";
                   
                $artist_data=artist_get_info($artist_url);
                $artist_data=json_decode($artist_data);
                  
                //get artist image
                $artist_pic=(array)$artist_data->artist->image[3];
                $artist_pic=$artist_pic['#text'];
                    
                   
    
    
    

                ///fetch artist records from table
                $where = array('id' => $itunes_data['artistId']);
                $is_artist_added	=	GetByWhere('artists', $where);
                 
                

                // artist table data update
                $artist_update_data['id']=$itunes_data['artistId'];
                $artist_update_data['artist_seo']=Slug($itunes_data['artistName']);
                $artist_update_data['keywords']= remove_spl_char($itunes_data['artistName']);
                $artist_update_data['itunes_url']= remove_spl_char($itunes_data['artistViewUrl']);
                $artist_update_data['artist_name']= remove_spl_char($itunes_data['artistName']);
                $artist_update_data['artist_description']=$artist_data->artist->bio->summary;
                $artist_update_data['summary']=$artist_data->artist->bio->summary;
                   

                ///
                if (empty($artist_update_data['artist_description'])) {
                    $artist_update_data['artist_description'] = 'No Description';
                    $artist_update_data['summary'] = 'No Summary';
                }
                $artist_update_data['artist_img']= $artist_pic;
                if (empty($artist_pic)) {
                    $artist_update_data['artist_img']= '';
                }
                $artist_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                $artist_update_data['posted_date']=time();
                     
                if ($artist_update_data['itunes_url']!="") {
                    if (!empty($is_artist_added) && !empty($artist_update_data)) {
                        UpdateRecord('artists', $where, $artist_update_data);
                    } else {
                        addNew('artists', $artist_update_data);
                    }
                }


                /******************************************************
                * ==========Update/Add Record To Artist Album Table====
                ******************************************************/


                     
                // album table data update
                $album_update_data['id']               =$itunes_data['collectionId'];
                $album_update_data['album_title']      = remove_spl_char($itunes_data['collectionName']);
                $album_update_data['album_seo']        =Slug($itunes_data['collectionName']);
                $album_update_data['album_artist_id']  =$itunes_data['artistId'];

                ///Album Table Update Section
                $album_api_record = album_get_info('http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=36cd9613641f2d9868a85377850aced5&artist='.$itunes_data['artistName'].'&album='.$itunes_data['collectionName'].'&format=json');
                $album_api_record=json_decode($album_api_record);
                //get album image
                $album_pic=(array)$album_api_record->album->image[3];
                $album_pic=$album_pic['#text'];
                if (empty($album_pic)) {
                    $album_pic = $artwork;
                }
 
                $album_update_data['album_picture']    =$album_pic;
                $album_update_data['years']            =$releaseDate[0];
                $album_update_data['price']            =$itunes_data['collectionPrice'];
                if (empty($album_update_data['price'])) {
                    $album_update_data['price'] = 0;
                }
                $album_update_data['track_count']       =$itunes_data['trackCount'];
                $album_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                $album_update_data['itunes_url']       = remove_spl_char($itunes_data['collectionViewUrl']);
                $album_update_data['posted_date']       =  time();
                $album_update_data['ranking_order']       =  1;
                   
                   
                    
                $where = array('id' => $album_update_data['id']);
                $artist_album	=	GetByWhere('artist_album', $where);
                  
    
    
                   
    
                if ($album_update_data['album_artist_id']!=""||$album_update_data['album_artist_id']!=0) {
                    if (empty($artist_album)) {
                        addNew('artist_album', $album_update_data);
                    } else {
                        UpdateRecord('artist_album', $where, $album_update_data);
                    }
                }



                /****************************************************************************
                * ==========Update/Add Record To Song Artist And Song Artist Album Table=====
                ****************************************************************************/


                ///update songs_artist table
                $where = array('song_id'=>$song_update_data['id'] , 'artist_id' => $artist_update_data['id']);
                $artist_already = GetByWhere('songs_artist', $where);
                    
                $update_songs_artist = array();
                $update_songs_artist['song_id'] = $song_update_data['id'];
                $update_songs_artist['artist_id'] = $artist_update_data['id'];
                $update_songs_artist['posted_date'] = time();
                $update_songs_artist['display_status'] = 1;

                ///
                $update_songs_artist_album = array();
                $update_songs_artist_album['song_id'] = $song_update_data['id'];
                $update_songs_artist_album['artist_id'] = $artist_update_data['id'];
                $update_songs_artist_album['album_id'] = $album_update_data['id'];
                $update_songs_artist_album['posted_date'] = time();
                $update_songs_artist_album['display_status'] = 1;
                    
                if (empty($artist_already) && $song_update_data['id']!=0 && $artist_update_data['id']!=0) {
                    addNew('songs_artist', $update_songs_artist);
                    addNew('songs_artist_album', $update_songs_artist_album);
                } else {
                    UpdateRecord('songs_artist', array('song_id'=>$song_update_data['id'],'artist_id' => $artist_update_data['id']), $update_songs_artist);
                    UpdateRecord('songs_artist_album', array('song_id'=>$song_update_data['id'],'artist_id' => $artist_update_data['id'],'album_id' => $album_update_data['id']), $update_songs_artist_album);
                }
            }
            $i++;
        }
    }

  

    ///Load_Itunes_Cron_Fetch_Albums_And_Songs
    public function Load_Itunes_Cron_Fetch_Albums_And_Songs()
    {
        $i=0;
        while ($i<15) {
            $SQL="select id from tbl_artists where updated_by_itunes='0000-00-00 00:00:00' order by rand()";
            $artist	=	\App\Models\Songs::GetRawDataAdmin($SQL);
            echo '<pre>';
            print_r($artist);
            echo '</pre>';
            die;

            if ($artist) {
                $artist_id=$artist['id'];
                $url="https://itunes.apple.com/lookup?id=".$artist_id."&entity=album";

                $itunesData=get_data($url);


                $itunesData=json_decode($itunesData);
                $k=0;

                foreach ($itunesData->results as $key=>$value) {
                    $itunes_collection=(array)$value;
                    $k=1;
    
                    if ($itunes_collection['collectionType']=='Album') {
                        $itunes_collection_url=	"https://itunes.apple.com/lookup?id=".$itunes_collection['collectionId']."&entity=song";
                
                        $itunesCollectionData=get_data($itunes_collection_url);

                        $itunesCollectionData=json_decode($itunesCollectionData);
        
        
                        foreach ($itunesCollectionData->results as $col_key=>$collectionSong) {
                            $itunesSongData=(array)$collectionSong;
                
                            if ($itunesSongData['wrapperType']=='collection') {
                                $album_update_data['itunes_url']       = remove_spl_char($itunesSongData['collectionViewUrl']);
                            }
                            if ($itunesSongData['wrapperType']=='track') {
                                
                                /// Code to add/update an song to database starts
                
                                $song_url="http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=".trim($itunesSongData['artistName'])."&track=".trim($itunesSongData['trackName'])."&api_key=36cd9613641f2d9868a85377850aced5&format=json";
                                $song_data=get_data($song_url);
                                $song_data=json_decode($song_data);
                    
                    
                                $artist_url="http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=".trim($itunesSongData['artistName'])."&api_key=36cd9613641f2d9868a85377850aced5&format=json";
                                $artist_data=get_data($artist_url);
                                $artist_data=json_decode($artist_data);

                                $artist_pic=(array)$artist_data->artist->image[3];
                    

                                // song table data update
                                $itunesSongData['trackName']=addslashes($itunesSongData['trackName']);
                                $song_update_data['id']=$itunesSongData['trackId'];
                    
                                $song_update_data['song_title']= remove_spl_char($itunesSongData['trackName']);
                    
                                $song_update_data['keywords']= remove_spl_char($itunesSongData['trackName']);
                                $song_update_data['song_seo']=Slug($itunesSongData['trackName']);
                                $song_update_data['lastfm_url']= remove_spl_char($song_data->track->url);
                                $artwork=explode("/", $itunesSongData['artworkUrl100']);
                                array_pop($artwork);
                                $artwork=implode("/", $artwork);
                                $artwork.= "/170x170bb.jpg";
                    
                                $song_update_data['picture']=$artwork;
                                $releaseDate=explode("-", $itunesSongData['releaseDate']);
                                $song_update_data['song_year']=$releaseDate[0];
                                $song_update_data['itunes_url']= remove_spl_char($itunesSongData['trackViewUrl']);
                                $song_update_data['itunes_price']=$itunesSongData['trackPrice'];
                                $song_update_data['country']= remove_spl_char($itunesSongData['country']);
                                $song_update_data['currency']=$itunesSongData['currency'];
                                $song_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                                $song_update_data['description']=remove_spl_char($song_data->track->wiki->summary);
                                $SQL="select id from tbl_songs where id='".$itunesSongData['trackId']."'";
                                $is_song_exits	=	\App\Models\Songs::GetRawDataAdmin($SQL);
                    
                    
                                if (empty($is_song_exits)) {
                                    echo	$SONGS_SQL="INSERT INTO `tbl_songs` (`id`,`song_title`, `keywords`,`song_seo`,`lastfm_url`,`picture`,`song_year`,`itunes_url`,`itunes_price`,`country`,`description`,`currency`,`updated_by_itunes`,`posted_date`) VALUES ('".$song_update_data['id']."','".$song_update_data['song_title']."', '".$song_update_data['keywords']."', '".$song_update_data['song_seo']."', '".$song_update_data['lastfm_url']."', '".$song_update_data['picture']."', '".$album_update_data['song_year']."', '".$album_update_data['itunes_url']."', '".$album_update_data['itunes_price']."', '".$album_update_data['country']."', '".$album_update_data['description']."', '".$album_update_data['currency']."', '".$album_update_data['updated_by_itunes']."','".time()."')";
                                    \App\Models\Songs::GetRawDataAdmin($SONGS_SQL);
                                } else {
                                    echo 1;
                                }
                    
                                // album table data update
                                $album_update_data['id']               =$itunesSongData['collectionId'];
                                $album_update_data['album_title']      =remove_spl_char($itunesSongData['collectionName']);
                                $album_update_data['album_seo']        =Slug($itunesSongData['collectionName']);
                                $album_update_data['album_artist_id']  =$itunesSongData['artistId'];
                                $album_update_data['album_picture']    =$artwork;
                                $album_update_data['years']            =$releaseDate[0];
                                $album_update_data['price']            =$itunesSongData['collectionPrice'];
                                $album_update_data['trackCount']       =$itunesSongData['trackCount'];
                                $album_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                    
                                // fetching description and artist image
                                // artist table data update
                                $artist_update_data['id']=$itunesSongData['artistId'];
                                $album_update_data['trackCount']       =$itunesSongData['trackCount'];
                         
                                $SQL="select id from tbl_artist_album where id='".$album_update_data['id']."'";
                                $artist_album	=	\App\Models\Songs::GetRawDataAdmin($SQL);
                        
                                if ($album_update_data['album_artist_id']!="" || $album_update_data['album_artist_id']!=0) {
                                    if (empty($artist_album)) {
                                        $ARTIST_ALBUM_SQL_1="INSERT INTO `tbl_artist_album` (`id`,`album_title`, `album_seo`,`album_artist_id`,`album_picture`,`years`,`price`,`track_count`,`itunes_url`,`updated_by_itunes`,`posted_date`) VALUES ('".$album_update_data['id']."','".$album_update_data['album_title']."', '".$album_update_data['album_seo']."', '".$album_update_data['album_artist_id']."', '".$album_update_data['album_picture']."', '".$album_update_data['years']."', '".$album_update_data['price']."', '".$album_update_data['trackCount']."', '".$album_update_data['itunes_url']."', '".$album_update_data['updated_by_itunes']."','".time()."')";
                                        \App\Models\Songs::GetRawDataAdmin($ARTIST_ALBUM_SQL_1);
                                    } else {
                                        echo 1;
                                    }
                                }
                                $SQL="select id from tbl_songs_artist where song_id='".$song_update_data['id']."' and artist_id='".$artist_update_data['id']."'";
                                $artist_already	=	\App\Models\Songs::GetRawDataAdmin($SQL);
                                if (empty($artist_already) && $song_update_data['id']!=0 && $artist_update_data['id']!=0) {
                                    $songs_artist="INSERT INTO `tbl_songs_artist` (`song_id`, `artist_id`,`posted_date`,`display_status`) VALUES ('".$song_update_data['id']."', '".$artist_update_data['id']."','".time()."',1)";
                                    \App\Models\Songs::GetRawDataAdmin($songs_artist);
                            

                                    $songs_artist_album="INSERT INTO `tbl_songs_artist_album` (`song_id`, `artist_id`,`album_id`,`posted_date`,`display_status`) VALUES ('".$song_update_data['id']."', '".$artist_update_data['id']."','".$album_update_data['id']."','".time()."',1)";
                                    \App\Models\Songs::GetRawDataAdmin($songs_artist_album);
                                }
                            }
                            /// Code to add/update an song to database ends
                        }
        
                        $artist_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                        if ($artist_update_data['id']!='') {
                            echo	"<br/>".$ARTIST_SQL=	"UPDATE `tbl_artists` SET 
							`updated_by_itunes` = '".$artist_update_data['updated_by_itunes']."' WHERE  `tbl_artists`.`id` ='".$artist_update_data['id']."'" ;
                            
                            \App\Models\Songs::GetRawDataAdmin($ARTIST_SQL);
                        }
                    }
                }


    
                $artist_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                if ($artist_update_data['id']!='') {
                    echo	"<br/>".$ARTIST_SQL=	"UPDATE `tbl_artists` SET 
							`updated_by_itunes` = '".$artist_update_data['updated_by_itunes']."' WHERE  `tbl_artists`.`id` ='".$artist_id."'" ;
                        
                    \App\Models\Songs::GetRawDataAdmin($ARTIST_SQL);
                }
            }
            //echo "executed";
            $i++;
        }
    }

    ///Load_Itunes_Cron_From_Song_Artist
    public function Load_Itunes_Cron_From_Song_Artist()
    {
        echo $SQL="SELECT artist_id, id FROM `tbl_songs_artist` where cron_status = 0 AND `artist_id` not in(SELECT `id` FROM `tbl_artists`) group by artist_id order by rand() limit 8";
        $albums	=	\App\Models\Songs::GetRawData($SQL);
        
        foreach ($albums as $key=>$value) {
            $value=(array)$value;
            $get_art_id = $value['id'];
    
            if ($value['artist_id']!=0) {
                $itunes_collection_url=	"https://itunes.apple.com/lookup?id=".$value['artist_id']."&entity=song";
                
                $itunesCollectionData=get_data($itunes_collection_url);

                $itunesCollectionData=json_decode($itunesCollectionData);
        
        
                foreach ($itunesCollectionData->results as $col_key=>$collectionSong) {
                    $itunesSongData=(array)$collectionSong;
                
                    if ($itunesSongData['wrapperType']=='collection') {
                        $album_update_data['itunes_url']       = remove_spl_char($itunesSongData['collectionViewUrl']);
                    }
                    if ($itunesSongData['wrapperType']=='track') {
                                
                        /// Code to add/update an song to database starts
                
                        $song_url="http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=".trim($itunesSongData['artistName'])."&track=".trim($itunesSongData['trackName'])."&api_key=36cd9613641f2d9868a85377850aced5&format=json";
                        $song_data=get_data($song_url);
                        $song_data=json_decode($song_data);

                    
                        $artist_url="http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=".trim($itunesSongData['artistName'])."&api_key=36cd9613641f2d9868a85377850aced5&format=json";
                        $artist_data=get_data($artist_url);
                        $artist_data=json_decode($artist_data);

                        $artist_pic=(array)$artist_data->artist->image[3];
                    
                    

                        // song table data update
                        $itunesSongData['trackName']=addslashes($itunesSongData['trackName']);
                        $song_update_data['id']=$itunesSongData['trackId'];
                    
                        $song_update_data['song_title']= remove_spl_char($itunesSongData['trackName']);
                    
                        $song_update_data['keywords']= remove_spl_char($itunesSongData['trackName']);
                        $song_update_data['song_seo']=Slug($itunesSongData['trackName']);
                        $song_update_data['lastfm_url']= remove_spl_char($song_data->track->url);
                        $artwork=explode("/", $itunesSongData['artworkUrl100']);
                        array_pop($artwork);
                        $artwork=implode("/", $artwork);
                        $artwork.= "/170x170bb.jpg";
                    
                        $song_update_data['picture']=$artwork;
                        $releaseDate=explode("-", $itunesSongData['releaseDate']);
                        $song_update_data['song_year']=$releaseDate[0];
                        $song_update_data['itunes_url']= remove_spl_char($itunesSongData['trackViewUrl']);
                        $song_update_data['itunes_price']=$itunesSongData['trackPrice'];
                        $song_update_data['country']= remove_spl_char($itunesSongData['country']);
                        $song_update_data['currency']=$itunesSongData['currency'];
                        $song_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                        $song_update_data['description']=remove_spl_char($song_data->track->wiki->summary);
                        $SQL="select id from tbl_songs where id='".$itunesSongData['trackId']."'";
                        $is_song_exits	=	\App\Models\Songs::GetRawDataAdmin($SQL);
                    
                    
                    
                    
                        $SQL="select id from tbl_artists where id='".$itunesSongData['artistId']."'";
    
                        $is_artist_added	=	\App\Models\Songs::GetRawDataAdmin($SQL);

                        // artist table data update
                        $artist_update_data['id']=$itunesSongData['artistId'];
                        $artist_update_data['artist_seo']=Slug($itunesSongData['artistName']);
                        $artist_update_data['keywords']= remove_spl_char($itunesSongData['artistName']);
                        $artist_update_data['itunes_url']= remove_spl_char($itunesSongData['artistViewUrl']);
                        $artist_update_data['artist_name']= remove_spl_char($itunesSongData['artistName']);
                    
                    
                        $artist_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                
                        if ($artist_update_data['itunes_url']!="") {
                            if (!empty($is_artist_added)) {
                                $ARTIST_SQL=	"UPDATE `tbl_artists` SET ";
                                $artist_update_data['lastfm_url']= remove_spl_char($artist_data->artist->url);
                                $ARTIST_SQL.="`lastfm_url`='".$artist_update_data['lastfm_url']."'";
                        
                                $artist_update_data['artist_img']= $artist_pic['#text'];
                                //	$ARTIST_SQL.=",`artist_img`='".$artist_update_data['artist_img']."'";
                    
                                $artist_update_data['artist_description']= remove_spl_char($artist_data->artist->bio->content);
                                $ARTIST_SQL.=",`artist_description`='".$artist_update_data['artist_description']."'";
                    
                                $artist_update_data['summary']=remove_spl_char($artist_data->artist->bio->summary);
                                $ARTIST_SQL.=",`summary`='".$artist_update_data['summary']."'";
                                //`artist_name` = '".$artist_update_data['artist_name']."',
                                $ARTIST_SQL.=",`keywords` = '".$artist_update_data['keywords']."',
							`itunes_url` = '".$artist_update_data['itunes_url']."',
							`updated_by_itunes` = '".$artist_update_data['updated_by_itunes']."' WHERE  `tbl_artists`.`id` ='".$artist_update_data['id']."'" ;
                            
                                \App\Models\Songs::GetRawDataAdmin($ARTIST_SQL);
                                echo "<hr>";
                            } else {
                                $ARTIST_SQL="INSERT INTO `tbl_artists` (`id`,`artist_seo`, `keywords`,`lastfm_url`,`itunes_url`,`artist_name`,`artist_description`,`summary`,`artist_img`,`updated_by_itunes`,`posted_date`) VALUES ('".$artist_update_data['id']."','".$artist_update_data['artist_seo']."', '".$artist_update_data['keywords']."', '".$artist_update_data['lastfm_url']."', '".$artist_update_data['itunes_url']."','".$artist_update_data['artist_name']."','".$artist_update_data['artist_description']."','".$artist_update_data['summary']."','".$artist_update_data['artist_img']."','".$album_update_data['updated_by_itunes']."','".time()."')";
                         
                         

                                \App\Models\Songs::GetRawDataAdmin($ARTIST_SQL);
                            }
                        }
                     
                    
                    
                        if (empty($is_song_exits)) {
                            echo	$SONGS_SQL="INSERT INTO `tbl_songs` (`id`,`song_title`, `keywords`,`song_seo`,`lastfm_url`,`picture`,`song_year`,`itunes_url`,`itunes_price`,`country`,`description`,`currency`,`updated_by_itunes`,`posted_date`) VALUES ('".$song_update_data['id']."','".$song_update_data['song_title']."', '".$song_update_data['keywords']."', '".$song_update_data['song_seo']."', '".$song_update_data['lastfm_url']."', '".$song_update_data['picture']."', '".$album_update_data['song_year']."', '".$album_update_data['itunes_url']."', '".$album_update_data['itunes_price']."', '".$album_update_data['country']."', '".$album_update_data['description']."', '".$album_update_data['currency']."', '".$album_update_data['updated_by_itunes']."','".time()."')";
                            \App\Models\Songs::GetRawDataAdmin($SONGS_SQL);
                        } else {
                            echo 1;
                        }
                     
                    
                        // album table data update
                        $album_update_data['id']               =$itunesSongData['collectionId'];
                        $album_update_data['album_title']      =remove_spl_char($itunesSongData['collectionName']);
                        $album_update_data['album_seo']        =Slug($itunesSongData['collectionName']);
                        $album_update_data['album_artist_id']  =$itunesSongData['artistId'];
                        $album_update_data['album_picture']    =$artwork;
                        $album_update_data['years']            =$releaseDate[0];
                        $album_update_data['price']            =$itunesSongData['collectionPrice'];
                        $album_update_data['trackCount']       =$itunesSongData['trackCount'];
                        $album_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                        
                        // fetching description and artist image
                        
                        
                        // artist table data update
                        $artist_update_data['id']=$itunesSongData['artistId'];

                        
                        
                        $album_update_data['trackCount']       =$itunesSongData['trackCount'];
                        
                        
                        
                        
                        $SQL="select id from tbl_artist_album where id='".$album_update_data['id']."'";
                        $artist_album	=	\App\Models\Songs::GetRawDataAdmin($SQL);
                        
                        if ($album_update_data['album_artist_id']!="" || $album_update_data['album_artist_id']!=0) {
                            if (empty($artist_album)) {
                                $ARTIST_ALBUM_SQL_1="INSERT INTO `tbl_artist_album` (`id`,`album_title`, `album_seo`,`album_artist_id`,`album_picture`,`years`,`price`,`track_count`,`itunes_url`,`updated_by_itunes`,`posted_date`) VALUES ('".$album_update_data['id']."','".$album_update_data['album_title']."', '".$album_update_data['album_seo']."', '".$album_update_data['album_artist_id']."', '".$album_update_data['album_picture']."', '".$album_update_data['years']."', '".$album_update_data['price']."', '".$album_update_data['trackCount']."', '".$album_update_data['itunes_url']."', '".$album_update_data['updated_by_itunes']."','".time()."')";
                                \App\Models\Songs::GetRawDataAdmin($ARTIST_ALBUM_SQL_1);
                            } else {
                                $ARTIST_ALBUM_SQL_1 =	"UPDATE `tbl_artist_album` SET `album_title` = '".$album_update_data['album_title']."' 
								,`album_seo` = '".$album_update_data['album_seo']."',
								`album_artist_id` = '".$album_update_data['album_artist_id']."',
								`album_picture` = '".$album_update_data['album_picture']."',
								`years` = '".$album_update_data['years']."',
								`price` = '".$album_update_data['price']."',
								`track_count` = '".$album_update_data['trackCount']."',
								`itunes_url` = '".$album_update_data['itunes_url']."',
								`updated_by_itunes` = '".$album_update_data['updated_by_itunes']."' WHERE `updated_by_itunes` = '0000-00-00 00:00:00' and `tbl_artist_album`.`id` ='".$album_update_data['id']."'" ;
                                
                                \App\Models\Songs::GetRawDataAdmin($ARTIST_ALBUM_SQL_1);
                            }
                        }
                        $SQL="select id from tbl_songs_artist where song_id='".$song_update_data['id']."' and artist_id='".$artist_update_data['id']."'";
                        $artist_already	=	\App\Models\Songs::GetRawDataAdmin($SQL);
                        if (empty($artist_already) && $song_update_data['id']!=0 && $artist_update_data['id']!=0) {
                            $songs_artist="INSERT INTO `tbl_songs_artist` (`song_id`, `artist_id`,`posted_date`,`display_status`) VALUES ('".$song_update_data['id']."', '".$artist_update_data['id']."','".time()."',1)";
                            \App\Models\Songs::GetRawDataAdmin($songs_artist);
                            

                            $songs_artist_album="INSERT INTO `tbl_songs_artist_album` (`song_id`, `artist_id`,`album_id`,`posted_date`,`display_status`) VALUES ('".$song_update_data['id']."', '".$artist_update_data['id']."','".$album_update_data['id']."','".time()."',1)";
                            \App\Models\Songs::GetRawDataAdmin($songs_artist_album);
                        }
                    }
                    /// Code to add/update an song to database ends
                }
            }

    

            $query_update="update tbl_songs_artist set cron_status = 1 where id = '$get_art_id'";
            \App\Models\Songs::GetRawDataAdmin($query_update);
        }
    }


    ///Load_Itunes_Cron_Add_Artists_And_Songs_By_Album
    public function Load_Itunes_Cron_Add_Artists_And_Songs_By_Album()
    {
        error_reporting(0);
        $SQL	=	"SELECT album_artist_id FROM `tbl_artist_album` where `album_artist_id` not in(SELECT `id` FROM `tbl_artists`) GROUP by album_artist_id order by rand() limit 30";
        $albums	=	\App\Models\Songs::GetRawData($SQL);
        echo '<pre>';
        print_r($albums);
        echo '</pre>';
        die;
  
  
        foreach ($albums as $key=>$value) {
            $value=(array)$value;
            if ($value['album_artist_id']!=0) {
                $itunes_collection_url=	"https://itunes.apple.com/lookup?id=".$value['album_artist_id']."&entity=song";
                          
                $itunesCollectionData=get_data($itunes_collection_url);
          
                $itunesCollectionData=json_decode($itunesCollectionData);
                  
                  
                foreach ($itunesCollectionData->results as $col_key=>$collectionSong) {
                    $itunesSongData=(array)$collectionSong;
                          
                    if ($itunesSongData['wrapperType']=='collection') {
                        $album_update_data['itunes_url']       = remove_spl_char($itunesSongData['collectionViewUrl']);
                    }
                          
                    if ($itunesSongData['wrapperType']=='track') {
                                          
                          /// Code to add/update an song to database starts
                          
                        $song_url="http://ws.audioscrobbler.com/2.0/?method=track.getInfo&artist=".trim($itunesSongData['artistName'])."&track=".trim($itunesSongData['trackName'])."&api_key=36cd9613641f2d9868a85377850aced5&format=json";
                        $song_data=get_data($song_url);
                        $song_data=json_decode($song_data);
          
                              
                        $artist_url="http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=".trim($itunesSongData['artistName'])."&api_key=36cd9613641f2d9868a85377850aced5&format=json";
                        $artist_data=get_data($artist_url);
                        $artist_data=json_decode($artist_data);
          
                        $artist_pic=(array)$artist_data->artist->image[3];
                              
                              
          
                        // song table data update
                        $itunesSongData['trackName']=addslashes($itunesSongData['trackName']);
                        $song_update_data['id']=$itunesSongData['trackId'];
                              
                        $song_update_data['song_title']= remove_spl_char($itunesSongData['trackName']);
                              
                        $song_update_data['keywords']= remove_spl_char($itunesSongData['trackName']);
                        $song_update_data['song_seo']=Slug($itunesSongData['trackName']);
                        $song_update_data['lastfm_url']= remove_spl_char($song_data->track->url);
                        $artwork=explode("/", $itunesSongData['artworkUrl100']);
                        array_pop($artwork);
                        $artwork=implode("/", $artwork);
                        $artwork.= "/170x170bb.jpg";
                              
                        $song_update_data['picture']=$artwork;
                        $releaseDate=explode("-", $itunesSongData['releaseDate']);
                        $song_update_data['song_year']=$releaseDate[0];
                        $song_update_data['itunes_url']= remove_spl_char($itunesSongData['trackViewUrl']);
                        $song_update_data['itunes_price']=$itunesSongData['trackPrice'];
                        $song_update_data['country']= remove_spl_char($itunesSongData['country']);
                        $song_update_data['currency']=$itunesSongData['currency'];
                        $song_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                        $song_update_data['description']=remove_spl_char($song_data->track->wiki->summary);
                        $SQL="select id from tbl_songs where id='".$itunesSongData['trackId']."'";
                        $is_song_exits	=	\App\Models\Songs::GetRawDataAdmin($SQL);
                              
                              
                              
                              
                        $SQL="select id from tbl_artists where id='".$itunesSongData['artistId']."'";
              
                        $is_artist_added	=	\App\Models\Songs::GetRawDataAdmin($SQL);
          
                        // artist table data update
                        $artist_update_data['id']=$itunesSongData['artistId'];
                        $artist_update_data['artist_seo']=Slug($itunesSongData['artistName']);
                        $artist_update_data['keywords']= remove_spl_char($itunesSongData['artistName']);
                        $artist_update_data['itunes_url']= remove_spl_char($itunesSongData['artistViewUrl']);
                        $artist_update_data['artist_name']= remove_spl_char($itunesSongData['artistName']);
                              
                              
                        $artist_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                          
                        if ($artist_update_data['itunes_url']!="") {
                            if (!empty($is_artist_added)) {
                                echo 1;
                            } else {
                                echo	"<br/>".$ARTIST_SQL="INSERT INTO `tbl_artists` (`id`,`artist_seo`, `keywords`,`lastfm_url`,`itunes_url`,`artist_name`,`artist_description`,`summary`,`artist_img`,`updated_by_itunes`,`posted_date`) VALUES ('".$artist_update_data['id']."','".$artist_update_data['artist_seo']."', '".$artist_update_data['keywords']."', '".$artist_update_data['lastfm_url']."', '".$artist_update_data['itunes_url']."','".$artist_update_data['artist_name']."','".$artist_update_data['artist_description']."','".$artist_update_data['summary']."','".$artist_update_data['artist_img']."','".$album_update_data['updated_by_itunes']."','".time()."')";
                                \App\Models\Songs::GetRawDataAdmin($ARTIST_SQL);
                            }
                        }
                               
                              
                        if (empty($is_song_exits)) {
                            echo	$SONGS_SQL="INSERT INTO `tbl_songs` (`id`,`song_title`, `keywords`,`song_seo`,`lastfm_url`,`picture`,`song_year`,`itunes_url`,`itunes_price`,`country`,`description`,`currency`,`updated_by_itunes`,`posted_date`) VALUES ('".$song_update_data['id']."','".$song_update_data['song_title']."', '".$song_update_data['keywords']."', '".$song_update_data['song_seo']."', '".$song_update_data['lastfm_url']."', '".$song_update_data['picture']."', '".$album_update_data['song_year']."', '".$album_update_data['itunes_url']."', '".$album_update_data['itunes_price']."', '".$album_update_data['country']."', '".$album_update_data['description']."', '".$album_update_data['currency']."', '".$album_update_data['updated_by_itunes']."','".time()."')";
                            \App\Models\Songs::GetRawDataAdmin($SONGS_SQL);
                        } else {
                            echo 2;
                        }
                              
                        // album table data update
                        $album_update_data['id']               =$itunesSongData['collectionId'];
                        $album_update_data['album_title']      =remove_spl_char($itunesSongData['collectionName']);
                        $album_update_data['album_seo']        =Slug($itunesSongData['collectionName']);
                        $album_update_data['album_artist_id']  =$itunesSongData['artistId'];
                        $album_update_data['album_picture']    =$artwork;
                        $album_update_data['years']            =$releaseDate[0];
                        $album_update_data['price']            =$itunesSongData['collectionPrice'];
                        $album_update_data['track_count']       =$itunesSongData['trackCount'];
                        $album_update_data['updated_by_itunes']=date("Y-m-d H:i:s");
                        //	$album_update_data['itunes_url']       = remove_spl_char($itunesSongData['collectionViewUrl']);
                        // fetching description and artist image
                                  
                                  
                        // artist table data update
                        $artist_update_data['id']=$itunesSongData['artistId'];
                        $album_update_data['trackCount']       =$itunesSongData['trackCount'];
                                  
                        $SQL="select id from tbl_artist_album where id='".$album_update_data['id']."'";
                        $artist_album	=	\App\Models\Songs::GetRawDataAdmin($SQL);
                                  
                        if ($album_update_data['album_artist_id']!="" || $album_update_data['album_artist_id']!=0) {
                            if (empty($artist_album)) {
                                $ARTIST_ALBUM_SQL_1="INSERT INTO `tbl_artist_album` (`id`,`album_title`, `album_seo`,`album_artist_id`,`album_picture`,`years`,`price`,`track_count`,`itunes_url`,`updated_by_itunes`,`posted_date`) VALUES ('".$album_update_data['id']."','".$album_update_data['album_title']."', '".$album_update_data['album_seo']."', '".$album_update_data['album_artist_id']."', '".$album_update_data['album_picture']."', '".$album_update_data['years']."', '".$album_update_data['price']."', '".$album_update_data['trackCount']."', '".$album_update_data['itunes_url']."', '".$album_update_data['updated_by_itunes']."','".time()."')";
                                \App\Models\Songs::GetRawDataAdmin($ARTIST_ALBUM_SQL_1);
                            } else {
                                echo 3;
                            }
                        }
                        $SQL="select id from tbl_songs_artist where song_id='".$song_update_data['id']."' and artist_id='".$artist_update_data['id']."'";
                        $artist_already	=	$SQL;
                        if (empty($artist_already) && $song_update_data['id']!=0 && $artist_update_data['id']!=0) {
                            $songs_artist="INSERT INTO `tbl_songs_artist` (`song_id`, `artist_id`,`posted_date`,`display_status`) VALUES ('".$song_update_data['id']."', '".$artist_update_data['id']."','".time()."',1)";
                            \App\Models\Songs::GetRawDataAdmin($songs_artist);
                                      
          
                            $songs_artist_album="INSERT INTO `tbl_songs_artist_album` (`song_id`, `artist_id`,`album_id`,`posted_date`,`display_status`) VALUES ('".$song_update_data['id']."', '".$artist_update_data['id']."','".$album_update_data['id']."','".time()."',1)";
                            \App\Models\Songs::GetRawDataAdmin($songs_artist_album);
                        }
                    }
                    /// Code to add/update an song to database ends
                }
            }
        }
    }
}
