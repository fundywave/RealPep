<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<?php
/*
 * DokuWiki Roundbox Template
 *
 * A template with a sidebar after the style of my homepage
 * <http://chrisarndt.de/>
 *
 * @link   http://wiki.splitbrain.org/wiki:tpl:roundbox
 * @author Chris Arndt <chris@chrisarndt.de>
 * @author Don Bowman  <don@lynsoft.co.uk>
 */

/******  include discussion code  ******/
if (in_array('discussion', plugin_list('syntax'))) { //do
    include(DOKU_PLUGIN . 'discussion/discussion.php');
    $have_discussion = true;
} //if (in_array('discussion', plugin_list('syntax'))) 
else
    $have_discussion = false;

/******  include template configuration and translations  ******/
//  include_once(dirname(__FILE__).'/conf/default.php');
include_once(dirname(__FILE__) . '/lang/en/lang.php');
@include_once(dirname(__FILE__) . '/lang/' . $conf['lang'] . '/lang.php');

/******  include sidebar code  ******/
//if (tpl_getConf('rb_sitenav'))     include(dirname(__FILE__).'/sidebar.php');

/******  include template helper functions  ******/
include_once(dirname(__FILE__) . '/roundbox.php');


$user = rb_get_user_info();
$perms = auth_quickaclcheck($ID);

/*
 * we must move the doctype down (unfortunately) - headers need to be first
 */
?>
<?php
/*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
*/
?>
<!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        <?php tpl_pagetitle() ?>
        [<?php echo hsc($conf['title']) ?>]
    </title>

    <?php tpl_metaheaders() ?>

    <?php rb_checkTheme() ?>

    <link rel="shortcut icon" href="<?php echo tpl_basedir() ?>images/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <?php if (tpl_getConf('rb_roundcorners')) { ?>
        <link rel="stylesheet" media="screen" type="text/css" href="<?php echo tpl_basedir() ?>roundcorners.css" />

    <?php } ?>




    <!--?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?-->

    <?php
    /*Loading menu style*/
    $style = tpl_basedir() . 'customstyles/general.css?'.date('Ymdhis');
    $style1 = tpl_basedir() . 'customstyles/bootstrapSubmenu.css?'.date('Ymdhis');
    $style2 = tpl_basedir() . 'customstyles/projectInfoAccordion.css?'.date('Ymdhis');
    $style3 = tpl_basedir() . 'customstyles/image-map-highlighter.css?'.date('Ymdhis');
    echo "<link rel='stylesheet' type='text/css' href=$style>";
    echo "<link rel='stylesheet' type='text/css' href=$style1>";
    echo "<link rel='stylesheet' type='text/css' href=$style2>";
    echo "<link rel='stylesheet'  type='text/css' href=$style3>";
    ?>
</head>

<body>
    <?php /*old includehook*/ @include(dirname(__FILE__) . '/topheader.html') ?>
    <?php flush() ?>





    <!-- start dokuwiki block -->
    <div class="dokuwiki">

        <!-- start header block -->
        <div id="header">

            <!-- start header title -->
            <div id="header_title">
                <div class="logo">
                    <?php tpl_link(wl(), $conf['title'], 'name="dokuwiki__top" id="dokuwiki__top" accesskey="h" title="[ALT+H]"') ?>
                </div>
                <div class="pagename">
                    [[&nbsp;<?php if (rb_check_action_perms('backlink', $perms, $user)) {
                                tpl_link(wl($ID, 'do=backlink'), $ID);
                            } else {
                                echo hsc($ID);
                            } ?>&nbsp;]]
                </div>
            </div>
            <!-- end header title -->
  
            <!-- start lower header part -->
            <div class="bar" id="header_bar">
                <!-- start tagline -->
                <div class="bar__left" id="bar__topleft">
                    <span class="tagline"><?php echo hsc(tpl_getConf('rb_tagline')) ?></span>
                </div>
                <!-- end tagline -->

                <!-- start goto & search area -->
                <div class="bar__right" id="bar__topright">
                    <?php if (rb_check_action_perms('goto', $perms, $user)) { ?>
                        <form action="<?php echo DOKU_BASE ?>doku.php" accept-charset="utf-8" class="search" name="goto">
                            <input type="text" accesskey="g" name="id" class="edit" title="<?php echo $lang['tip_goto'] ?> [ALT-G]" />
                            <input type="submit" value="<?php echo $lang['btn_goto'] ?>" class="button" title="<?php echo $lang['tip_goto'] ?> [ALT-G]" />
                        </form>
                    <?php } ?>
                    <?php if (rb_check_action_perms('search', $perms, $user)) { ?>
                        <?php tpl_searchform() ?>&nbsp;
                    <?php } ?>
                </div>
                <!-- end goto & search area -->

            </div>
            <!-- end lower header part -->

        </div>
        <!-- end header block -->
        <?php /*old includehook*/ @include(dirname(__FILE__) . '/pageheader.html') ?>
        <?php /*old includehook*/ @include(dirname(__FILE__) . '/header.html') ?>
        <?php flush() ?>

        <!-- start content block Bootstrap adaptation -->
        <div class="container">

            <div class="centerpage">
                <?php html_msgarea() ?>

                <!-- wikipage start -->
                <?php
                if ($ACT == "register" || $ACT == "resendpwd")
                    tpl_content();
                else if (tpl_getConf('rb_private') && !$_SERVER['REMOTE_USER'])
                    html_login();
                else
                    tpl_content();

                $link = $_SERVER['REQUEST_URI'];
                if(strpos($link, "id")>0)
                {
                                $pos = strpos($link, "=");
                                
                                $page = substr($link, $pos + 1, strlen($link) - $pos);
                                if ($page == "home") {
                                    echo "<div class=container-fluid>";
                                } else {
                                    echo "<div class=hidden>";
                                };
                }
                else
                {
                        $a=0;
                            for ($i = 0; $i < strlen($link); $i++) {
                            if($link[$i]=="/")
                                $a=$i;
                            }
                        $page=substr($link,$a+1,strlen($link)-$a);
                        if ($page == "doku.php") {
                            echo "<div class=container-fluid>";
                        } else {
                            echo "<div class=hidden>";
                        };
                }
                ?>
                <!-- end wikipage -->

                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-10">
                        <img id="realpepproject" src="<?php echo tpl_basedir() ?>/images/project-bigger.png" width="900" height="248" class="realpepimage" usemap="#map" />
                        <div id="panelinfo1">
                            <div class="projectInfoAccordion">

                                <h1 class="display-3 text-center">P1:Quantitative Precipitation Estimantion(QPE)
                                </h1>
                                <br>
                                <strong>Core objectives:</strong><br> Improvement of PE for liquid, solid, and
                                mixed-phase precipitation, by<br>
                                <ul>
                                    <li>Full expolitation of radar polarimetry</li>
                                    <li>Improved processing of CML data</li>
                                    <li>Merging of CML and radar data and exploiting CML for constraining
                                        polarimetric
                                        QPE algorithms</li>
                                </ul>
                                <p><a style="color:blue" href="?id=project_p1">More information about QPE</a></p>
                                <p><a style="color:blue" href="?id=project_p1#current">Current Status</a></p>
                            </div>
                        </div>
                        <div id="panelinfo2">
                            <div class="projectInfoAccordion">
                                <h1 class="display-3 text-center">P2:Quantitative Precipitation Nowcasting(QPN)</h1>
                                <br>
                                <strong>Core objectives:</strong><br> Significantly enhance lead time and skill of
                                advection-based nowcasting via two pathways:<br>
                                <ul>
                                    <li>Extrapolate trends of the cells velocity, shape, intensity and size in time
                                    </li>
                                    <li>Exploit the information of especially polarimetry-based process descriptors
                                        on
                                        future developments</li>
                                </ul>
                                <p><a style="color:blue" href="?id=project_p2">More information about QPN</a></p>
                                <p><a style="color:blue" href="?id=project_p2#current">Current Status</a></p>
                            </div>
                        </div>
                        <div id="panelinfo3">
                            <div class="projectInfoAccordion">
                                <h1 class="display-3 text-center">P3:Quantitative Precipitation Forecasting(QPF)
                                </h1><br>
                                <strong>Core objectives:</strong><br> Enhanced QPF by assimilating precipitation
                                relevant radar and satellite information:<br>
                                <ul>
                                    <li>Polarimetric moments and radar-derived mixing ratios</li>
                                    <li>Gridded information from 3D composite</li>
                                    <li>Nowcastet fields</li>
                                </ul>
                                <p><a style="color:blue" href="?id=project_p3">More information about QPF</a></p>
                                <p><a style="color:blue" href="?id=project_p3#current">Current Status</a></p>

                            </div>
                        </div>
                        <div id="panelinfo4">
                            <div class="projectInfoAccordion">
                                <h1 class="display-3 text-center">P4:Flash Flood Prediction(FFP)</h1><br>
                                <strong>Core objectives:</strong><br> Advance river discharge forecast, particularly
                                flash-flood lead times:<br>
                                <ul>
                                    <li>Evaluate QPE/QPN/QPF data improved by P1,P2 and P3</li>
                                    <li>Apply a physically based hydrological model</li>
                                    <li>Improve real-time data assimilitation of discharge and soil moisture</li>
                                </ul>
                                <p><a style="color:blue" href="?id=project_p4">More information about FFP</a></p>
                                <p><a style="color:blue" href="?id=project_p4#current">Current Status</a></p>

                            </div>
                        </div>
                        <div id="panelinfo5">
                            <div class="projectInfoAccordion">
                                <h1 class="display-3 text-center">C1:Infrastructure project</h1><br>
                                <strong>Core objectives:</strong><br>
                                <ul>
                                    <li>Build and maintain a data collection and exploitation platform that mirrors
                                        the
                                        current status of best practice to organize, exhange, and implement data and
                                        algorithms between projects</li>
                                    <li>Fundamental research in convection initiation</li>
                                </ul>
                                <p><a style="color:blue" href="?id=project_c1">More information about
                                        Infrastructure</a></p>
                                <p><a style="color:blue" href="?id=project_c1#current">Current Status</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                </div>

                <map name="map">
                    <area id="panelinfo1" shape="rect"  alt="QPE" title="QPE" href="#" coords="26,57,97,89" onclick="CollapsePanelInfo('panelinfo1');return false;" type="button" role="button">
                    <area id="panelinfo2" shape="rect"  alt="QPN" title="QPN" href="#" coords="123,57,193,89" onclick="CollapsePanelInfo('panelinfo2');return false;" type="button" role="button">
                    <area id="panelinfo3" shape="rect"  alt="QPF" title="QPF" href="#" coords="215,57,675,89" onclick="CollapsePanelInfo('panelinfo3');return false;" type="button" role="button">
                    <area id="panelinfo4" shape="rect"  alt="Hydro" title="Hydro" href="#" coords="35,189,675,222" onclick="CollapsePanelInfo('panelinfo4');return false;" type="button" role="button">
                    <area id="panelinfo5" shape="rect"  alt="Infrastructure" title="Infrastructure" href="#" coords="353,17,537,49" onclick="CollapsePanelInfo('panelinfo5');return false;" type="button" role="button">
                </map>
            </div>





            <div class="toplink">
                <?php tpl_actionlink('top') ?>
            </div>


            <!-- start page meta information 
                <div class="meta">
                    <--?php tpl_pageinfo()?>
                </div>-->
        </div>

    </div>

    <!-- end content block -->

    <!-- Sidebar will start from here-->


    <!-- start sidebar -->

    <!-- start sidebar -->

    <!-- end sidebar -->



    </div>
    <!-- end dokuwiki block -->

    <?php tpl_indexerWebBug() ?>

    <?php /* @include(dirname(__FILE__).'/footer.html') */ ?>






    <?php
    /*Loading ustom js*/
    $script1 = tpl_basedir() . 'customjs/projectInfoAccordionJS.js';
    $script2 = tpl_basedir() . 'customjs/image-map-highlighter.js';
    echo "<script src=$script1></script>";
    echo "<script src=$script2></script>";
    ?>
    <script>
        var image = document.querySelector(".realpepimage");
        var highlighter = new ImageMapHighlighter(image, {
            strokeColor: "FFA500",
            fill: true,
            fillColor: "00ff00"
        });
        highlighter.init();
    </script>

</body>

</html>