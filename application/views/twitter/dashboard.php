<?php $x=0;

if(!empty($twitter)){


foreach ($twitter['twitterRecord'] as $item) {?>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $item['screen_name'] ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-danger m-r-sm"><?php echo $item['followers_count'] ?></button>
                                        Current Followers
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary m-r-sm"><?php echo $item['friends_count'] ?></button>
                                        Current Following
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info m-r-sm"><?php echo $item['statuses_count'] ?></button>
                                        Current Tweets
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-danger m-r-sm"><?php echo $item['favourites_count'] ?></button>
                                        Current Favorites
                                    </td>
                                   <td>
                                        <!--<button type="button" class="btn btn-info m-r-sm"><?php /*echo $item['screen_name'] */?></button>
                                        Current Retweets-->
                                    </td>
                                    <td>
                                        <!--<button type="button" class="btn btn-success m-r-sm"><?php /*echo $item['screen_name'] */?></button>
                                        Current Mentions-->
                                    </td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>



    <?php $x++; }

}
?>


<div class="row">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <a href="/twitter/accounts" class="btn btn-success btn-facebook">
                <i class="fa fa-twitter"> </i> Add Twitter Account
            </a>
        </div>
    </div>
</div>
