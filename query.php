<?php
include 'api/SteamAPI.php';
include 'api/SteamAPIDriver.php';
include 'api/SteamAPIDriverCached.php';
$steamdriver = new Neoseeker\SteamAPI\SteamAPIDriverCached;
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
    else{
        $keys = array();
    }
    foreach($infos as $account => $data){
        if(isset($data['status'])){
            echo "<div class='alert alert-warning'>Account ".htmlspecialchars($account).": ".$data['status']."</div>";
        }
    }
    if(count($keys) == 0){
        echo "<div class='alert alert-danger'>Can't find game you all own</div>";
    }
    else{
        $launch = $usable_games[$keys[array_rand($keys)]];
        echo '<div class="jumbotron">
                      <h1>'.$launch->name.'</h1>
                      <a href="steam://run/'.$launch->appID.'" class="btn btn-success">Launch</a>
                    </div>';
        echo "<div class='well'>Game: ".count($keys)."</div>";
        foreach($keys as $gameID){
            $game = $usable_games[$gameID];
            echo "<div class='row well game'><img src='".$game->logo."' width='200' class='img-thumbnail pull-left' /><a href='steam://run/".$game->appID."' class='btn btn-success pull-right'>Launch</a><h4>".$game->name."</h4></div>";
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
            echo "<div class='well'>Game: ".count($games)."</div>";
            foreach($games as $game){
                if(isset($game->hoursOnRecord)) $stats = "Played ".$game->hoursOnRecord." hours";
                else $stats = "not played yet";
                echo "<div class='row well game'><img src='".$game->logo."' width='200' class='img-thumbnail pull-left' /><a href='steam://run/".$game->appID."' class='btn btn-success pull-right'>Launch</a><h4>".$game->name."</h4><b>".$stats."</b></div>";
            }
        }
        else{
            echo "No Games available";
        }
    }
}
?>