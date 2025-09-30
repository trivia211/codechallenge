<?php
if ( !defined('ROOT') )
    define('ROOT', __DIR__ . "/..");

// badges received on the results page
abstract class Badges {
    // id=>filepath
    const LIST = array(
        '1'=>"/img/1-star.webp",
        '2'=>"/img/2-star.webp",
        '3'=>"/img/3-star.webp",
        '4'=>"/img/3-star-crown.webp"
    );

    // returns common width percent for all badges, so that setting this width and height to auto, all
    // badges will fit into a rectangular area, while keeping the size ratio between badge images and
    // using up as much space as possible
    static function getProportionalWidhts() {
        $ratio = 2.0;
        $widths = array();
        $bigImgWidth = null;
        foreach ( self::LIST as $id=>$path ) {
            $size = getimagesize(ROOT . $path);
            if ( $size[1] !== 0 && $size[1] > $size[0] )
                $currRatio = $size[0] / $size[1];
            else
                $currRatio = 1.0;
            $widths[$id] = $size[0];
            if ( $currRatio < $ratio ) {
                $ratio = $currRatio;
                $bigImgWidth = $size[0];
            }
        }
        $result = array();
        foreach ( $widths as $id=>$width )
            if ( $bigImgWidth !== 0 )
                $result[$id] = $width * $ratio / $bigImgWidth * 100.0;
            else
                $result[$id] = 0.0;
        return $result;
    }
}

?>
