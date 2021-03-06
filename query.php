<?php
include 'api/SteamAPI.php';
include 'api/SteamAPIDriver.php';
include 'api/SteamAPIDriverCached.php';
if($caching == true){
    $steamdriver = new Neoseeker\SteamAPI\SteamAPIDriverCached;
}
else{
    $steamdriver = new Neoseeker\SteamAPI\SteamAPIDriver;
}
$api = new Neoseeker\SteamAPI\SteamAPI($steamdriver);
if(stristr($_REQUEST['username'], ",")){
    $infos = array();
    $accounts = explode(",",$_REQUEST['username']);
    $usable_games = array();
    foreach ($accounts as $name) {
        $name = trim($name);
        $infos[$name] = array();
        $api->load($name);
        $infos[$name]['games'] = array();
        $infos[$name]['infos'] = $api->information;
        if($api->information == false){
            $infos[$name]['status'] = "Can't query account data. Maybe does the account not exist";
        }
        elseif(isset($api->information->privacyMessage)){
             $infos[$name]['status'] = $api->information->privacyMessage;
        }
        elseif($api->information->privacyState != "public"){
            $infos[$name]['status'] = "Account is not public (".$api->information->privacyState.")";
        }
        else{
            $games = $api->get_games();
            if(count($games)){
                $infos[$name]['games'] = $games;
                if(count($games) > count($usable_games)){
                    $usable_games = $games;
                }
            }
            else{
                $infos[$name]['status'] = "No Games available";
            }
        }
    }
    function get_games($account){
        return array_keys($account['games']);
    }

    $games = array_values(array_filter(array_map("get_games", $infos)));
    if(count($games) > 1){
        $keys = call_user_func_array("array_intersect",$games);
    }
    elseif(count($games) == 1){
        $keys = $games[0];
    }
    else{
        $keys = array();
    }
    /*
    foreach($infos as $account => $data){
        if(isset($data['status'])){
            echo "<div class='alert alert-warning'>Account ".htmlspecialchars($account).": ".$data['status']."</div>";
        }
    }
    */
    if(count($keys)){
        $launch = $usable_games[$keys[array_rand($keys)]];
        echo '<div class="jumbotron">
                      <h1>'.$launch->name.'</h1>
                      <a href="steam://run/'.$launch->appID.'" class="btn btn-success">Launch</a>
                    </div>';
    }
    echo '<ul class="list-group">';
        foreach($infos as $account => $data){
            if(count($data['games'])){
                $badge = count($data['games']);
            }
            else{
                $badge = "unknown";
            }
            $url = "http://steamcommunity.com/";
            if(isset($data['infos']->customURL) && count((array)($data['infos']->customURL))){
                $url .= 'id/'.$data['infos']->customURL;
            }
            else{
                $url .='profiles/'.$data['infos']->steamID64;
            }
            echo '<li class="list-group-item"><span class="badge">'.$badge.'</span><img class="img-circle" width="18" src="'.$data['infos']->avatarIcon.'" /><a target="_blank" href="'.$url.'">'.$data['infos']->steamID.'</a></li>';
        }
    echo '<li class="list-group-item active"><span class="badge">'.count($keys).'</span>Common Games</li>';
    echo '</ul>';
    if(count($keys)){
        foreach($keys as $gameID){
            $game = $usable_games[$gameID];
            echo "<div class='row game'><div class='col-md-12'><div class='well'><img src='".$game->logo."' width='200' class='img-thumbnail pull-left' /><a href='steam://run/".$game->appID."' class='btn btn-success pull-right'>Launch</a><h4>".$game->name."</h4><div class='clearfix'></div></div></div></div>";
        }
    }
}
else{
    $api->load($_REQUEST['username']);
    if($api->information == false){
        echo "<div class='alert alert-danger'>Can't query account data. Maybe does the account not exist</div>";
    }
    elseif(isset($api->information->privacyMessage)){
        echo "<div class='alert alert-danger'>".$api->information->privacyMessage."</div>";
    }
    elseif($api->information->privacyState != "public"){
        echo "<div class='alert alert-danger'>Account is not public (".$api->information->privacyState.")</div>";
    }
    else{
        $games = $api->get_games();
        if(count($games)){
            $launch = $games[array_rand($games)];
            echo '<div class="jumbotron">
                      <h1>'.$launch->name.'</h1>
                      <a href="steam://run/'.$launch->appID.'" class="btn btn-success">Launch</a>
                    </div>';
            echo '<ul class="list-group">';
                echo '<li class="list-group-item active"><span class="badge">'.count($games).'</span>Games</li>';
            echo '</ul>';
            foreach($games as $game){
                if(isset($game->hoursOnRecord)) $stats = "Played ".$game->hoursOnRecord." hours";
                else $stats = "not played yet";
                echo "<div class='row game'><div class='col-md-12'><div class='well'><img src='".$game->logo."' width='200' class='img-thumbnail pull-left' /><a href='steam://run/".$game->appID."' class='btn btn-success pull-right'>Launch</a><h4>".$game->name."</h4><b>".$stats."</b><div class='clearfix'></div></div></div></div>";
            }
        }
        else{
            echo "No Games available";
        }
    }
}
?>