<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 7/6/13
 * Time: 7:32 PM
 * To change this template use File | Settings | File Templates.
 */

class Htmlhelpers
{

    /* __construct
    * opens the html tag; {public}
    */

    /*public function __construct()
    {
        echo '<html>';
    }*/


    /* find
     * create a tag passed to it by calling its corresponding function
     *
     * Param description:
     * $tag - the tag to be created (eg:p,b) ; (string)
     *
     * Returns:
     * the corresponding returns for a called function
    */
    /* public function find($tag)
      {

      }*/

    /* _Doctype
     *
     * creates a doctype tag ; {public}
     *
     * Params description:
     * $type - the type of doctype to be created [ 'html5' ]; (string)
     *
     * Returns:
     *  returns a formatted doctype tag [ <!doctype html> ]; (string)
     */

    public static function Doctype($type = '')
    {
        //open s doctype tag
        $doc = '<!DOCTYPE html';

        /* if there is a type for the tag
        * use the suitable attribute
        * else use a default
        */
        if (empty($type)) {
            $doc .= ' PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
        } elseif ('html5' == strtolower($type)) {
            $doc .= '>';
        } elseif ('html4-trans' == strtolower($type)) {
            $doc .= ' PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
        }

        //return a formatted doctype tag
        return $doc;
    }

    /* _Charset
     *
     * Used to create a meta tag specifying the document’s character. Defaults to UTF-8
     *
     * Params description:
     * $charset - The desired character set. if null, the default is UTF-8
     *
     * Returns:
     *  returns a formatted meta tag
     */

    public static function Charset($charset = null)
    {
        //open a meta tag
        $meta = '<meta http-equiv="Content-Type" content="text/html;';

        /* if the charset value is null
        * use a default of utf-8
        * else use the specified charset value
        */
        $meta .= (is_null($charset)) ? 'charset = utf-8 />' : 'charset = ' . $charset . ' />';

        //return formatted meta tag
        return $meta;
    }

    /* _Head
    *
    * creates a formatted head tag [<head>]; {public}
    *
    *Params description:
    * $title - the page title; (string) | (optional)
    * $content - the content to be added to the head tag [<script>...</script>] ; (array) | (optional)
    *
    * Returns:
     * returns a formatted head tag [ <head><title>...</title>...</head> ]; (string)
    */

    public static function Head($title = 'title', array $content = [])
    {
        //open the head tag and put in the title
        $head = '<head><title>' . $title . '</title>';

        /*
         * if there is no content for the head tag
         * leave the head tag open
         * else put in the content and close the head tag
         */
        if (!empty($content)) {
            foreach ($content as $value) {
                $head .= $value . "\n";
            }

            $head .= '</head>';
        }

        //print the formatted head tag
        echo $head;
    }

    /* _Link
     *
     * creates a formatted link tag; {public}
     *
     * Params description:
     * $tag_attr - set of attributes to be applied to the tag; (array)
     * $repeat   - number of times to create the link tag; (integer) | (optional)
     *
     * Returns:
     *  returns a formatted link tag; (string)
     */

    public static function Link(array $tag_attr, $repeat = 1)
    {
        /*
         * initialize a counter to 1
         * initialize array index to 0
         */
        $count = 1;
        $index = 0;

        // initialize $link to an empty string
        $link = '';

        //loop until $count is greater than the number of times to repeat creation of the tag
        while ($count <= $repeat) {

            // if you want to create one link tag
            if ($repeat == 1) {
                //assign $attr with the single array
                $attr = $tag_attr;
            } else //if you want to create more than one link tag
            {
                //assign $attr with an indexed multidimensional array
                $attr = $tag_attr[$index];
            }

            $link .= '<link';
            //get the contents from the array
            foreach ($attr as $tag_key => $tag_value) {
                $link .= ' ' . $tag_key . ' = ' . $tag_value;
            }
            $link .= '/>';

            //increment count and array index
            $index++;
            $count++;
        }

        //return formatted link tag based on the number of time you want
        return $link;
    }


    /* _Css
     *
     * creates a formatted style tag [<style>]; {public}
     *
     * Params description:
     * $content  - the {attribute:value} pair content [ #id{color:#ccc;}]; (array)
     * $tag_attr - attributes for the tag; (array) | (optional)
     *
     * Returns:
     * Formatted style tag [<style>{attribute:value;}</style>] ; (string)
     */

    public static function Css(array $content = [], array $tag_attr = [])
    {
        //open the style tag
        $style = '<style';

        //if there attributes for the style, put the attributes in the opening tag
        if (!empty($tag_attr)) {
            foreach ($tag_attr as $attr_name => $attr_value) {
                $style .= ' ' . $attr_name . ' = ' . $attr_value;
            }
        }

        //if are styling or content put it after the opening tag
        //and close the style tag
        if (!empty($content)) {
            $style .= '>';
            foreach ($content as $attr => $value) {
                $style .= "\n" . $attr . '{' . $value . '}';
            }
            $style .= '</style>';
        } else //else do not close the style tag
        {
            $style .= '>';
        }

        //return rhe formatted style tag
        return $style;
    }

    /* create_tag
    *
     * creates a formatted  tag [ <p>, <script> ]; {public}
     *
     * Params description:
     * $tag - the tag to be formatted; (string)
     * $content   - the content that will appear inside the p tag; (string)
     * $tag_attr  - Attributes for the tag; (array) | (optional)
     *
     * Returns:
     * Formatted tag element ; (string)
    */
    public static function create_tag( $tag, $content, array $tag_attr = [])
    {
        //open the tag
        $tag = '<'.$tag;

        //check of there are attributes for the tag
        if(!empty($tag_attr))
        {
            foreach ($tag_attr as $attr_name => $attr_value) {

                //add each attribute between the tag
                $tag .= ' ' . $attr_name . ' = ' . $attr_value;
            }
        }

       /* If there is no content leave the tag open else close the tag */
       $tag .= (empty($content)) ? '>' : '>' . $content . '</'.$tag.'>';

       //return formatted tag
       return $tag;
    }

    /* _Para
    *
     * creates a formatted p tag [ <p> ]; {public}
     *
     * Params description:
     * $content   - the content that will appear inside the p tag; (string)
     * $tag_attr  - Attributes for the tag; (array) | (optional)
     *
     * Returns:
     * Formatted P element ; (string)
    */

    public static function Para($content = '', array $tag_attr = [])
    {
        //Open a p tag
        $p = '<p';

        //check if there are attributes for the p tag
        if (!empty($tag_attr)) {
            foreach ($tag_attr as $attr_name => $attr_value) {
                //add each attribute between the p tag
                $p .= ' ' . $attr_name . ' = ' . $attr_value;
            }
        }

        /* if there is a content for the tag close the tag
          * else leave the tag open
          */
        $p .= (empty($content)) ? '>' : '>' . $content . '</p>';

        //return formatted p tag
        return $p;
    }

    /* _Heading
     *
     * creates a Heading [ H1/H2/H3/... ] as specified; {public}
     *
     * Params description:
     * $content    -   the content that will appear inside the header tag; (string)
     * $Heading_no -   heading number [ 1,2,3... ]; (string)
     * $tag_attr   -   attributes for the tag; (array) | (optional)
    */

    public static function Heading($content, $Heading_no, array $tag_attr = [])
    {
        //open a heading tag
        $h = '<h' . $Heading_no;

        //check if there are attributes for the heading tag
        if (!empty($tag_attr)) {
            foreach ($tag_attr as $tag_key => $tag_value) {
                //add each attribute between the heading tag
                $h .= ' ' . $tag_key . ' = ' . $tag_value;
            }
        }

        /* if there is a content for the tag close the tag
         * else leave the tag open
         */
        $h .= (empty($content)) ? '>' : '>' . $content . '</h' . $Heading_no . '>';

        //return formatted p tag
        return $h;
    }

    /* _Break
     *
     * creates a break tag n number of times; {public}
     *
     * Params description:
     * $repeat - number of times to create the br tag [3]; (integer) | (optional)
     *
     * Returns:
     * a break tag [</br>]
     */

    public static function Newline($repeat = 1)
    {
        //return the break time n times
        return str_repeat('<br />', $repeat);
    }

    /* Nbsp
     *
     * creates a space n number of times; {public}
     *
     * Params description:
     * $repeat - number of times repeat spacing; (integer) | (optional)
     *
     * Returns:
     * a non breaking space[</br>]
     */
    public static function Nbsp($repeat = 1)
    {
        return str_repeat("&nbsp;", $repeat);
    }

    /* Image
     *
     * creates an Image tag [ <img> ]; {public}
     *
     * Params description:
     * $path    -   the path to the image; (string)
     * $tag_attr   -   attributes for the tag; (array) | (optional)
    */
    public static function Image($path, array $tag_attr = [])
    {
        //Open an img tag
        $img = '<img src="'.$path.'"';

        //check if there are attributes for the tag
        if (!empty($tag_attr)) {
            foreach ($tag_attr as $attr_name => $attr_value) {
                //add each attribute between the p tag
                $img .= ' ' . $attr_name . ' = ' . $attr_value;
            }
        }

        /* Close the img tag*/
        $img .= '/>';

        //return formatted p tag
        return $img;

    }

    /* Media
     *
     * creates an media tag [ <audio></audio>, <video></video> ]; {public}
     *
     * Params description:
     * $path    -   the path to the audio/video file; (string)
     * $tag_attr   -   attributes for the tag; (array) | (optional)
    */
    /*public static function Media($path, array $tag_attr)
    {

    }*/


    /* Nestedlist
     *
     * creates a nested list [ UL/OL ] out of an associative array. ; {public}
     *
     * Params description:
     * $tag - Type of list tag [ol/ul ];(string) | (optional)
     * $tag_attr - Attributes for the tag (ol/ul)(array) | (optional)
     * $list_attr - Attributes of the list item (Li) tag; (array) | (optional)
     * $items - items to be listed; (array)
     *
     * Returns:
     * Nested List; (string)
     **/

    /*public function Nestedlist(string $tag = 'ul', array $tag_attr = [], array $list_attr = [], array $items)
    {
        $list_tag = '<'.$tag;

        foreach ($tag_attr as $attr_name => $attr_value) {

            if(is_array($attr_name)
            {
                foreach ($attr_name as $key => $value)
                {
                    $list_tag .=
                }
            }

        }
    }*/

    /* _closetag
    *  closes a tag as specified; {public}
     *
     * Params description:
     * $tag - the tag to be closed i.e to add a closing tag for the specified tag ['p']; (string)
     * $no  - heading number for headings [1,2,3]
     *
     * Returns
     * returns a closing tag for the specified input/param [ </p>, </h3> ]- (string)
    */

    public static function _closetag($tag, $no = '')
    {
        //return a closing tag for $tag
        return '</' . $tag . $no . '>';
    }
}
