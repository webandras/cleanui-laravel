<?php
/* Config:
            'HTML.Allowed'             => 'div,b,strong,i,em,u,a[href|title],ul,ol,li,p[style],br,span[style],img[class|width|height|alt|src]', // add class to img!
            'HTML.SafeObject' => true, // Add this
            'Output.FlashCompat' => true, // and this
            'URI.DisableExternalResources' => false, // and this
            'Filter.Custom' => array (new HTMLPurifier_Filter_MyIframe()), // and apply the filter!
*/
/**
 * Based on: http://sachachua.com/blog/2011/08/drupal-html-purifier-embedding-iframes-youtube/
 * Put it here vendor/ezyang/htmlpurifier/library/HTMLPurifier/Filter/
 * https://stackoverflow.com/questions/4739284/htmlpurifier-iframe-vimeo-and-youtube-video/8581864#8581864
 * Iframe filter that does some primitive whitelisting in a somewhat recognizable and tweakable way
 *
 *
 */
class HTMLPurifier_Filter_MyIframe extends HTMLPurifier_Filter
{
    public $name = 'MyIframe';

    /**
     *
     * @param  string  $html
     * @param  HTMLPurifier_Config  $config
     * @param  HTMLPurifier_Context  $context
     * @return string
     */
    public function preFilter($html, $config, $context)
    {
        $html = preg_replace('#<iframe#i', '<img class="MyIframe"', $html);

        return preg_replace('#</iframe>#i', '</img>', $html);
    }

    /**
     *
     * @param  string  $html
     * @param  HTMLPurifier_Config  $config
     * @param  HTMLPurifier_Context  $context
     * @return string
     */
    public function postFilter($html, $config, $context)
    {
        $post_regex = '#<img class="MyIframe"([^>]+?)>#';
        return preg_replace_callback($post_regex, array($this, 'postFilterCallback'), $html);
    }

    /**
     *
     * @param  array  $matches
     * @return string
     */
    protected function postFilterCallback($matches): string
    {
        // Domain Whitelist
        $youTubeMatch = preg_match('#src="https?://www.youtube(-nocookie)?.com/#i', $matches[1]);
        $vimeoMatch = preg_match('#src="http://player.vimeo.com/#i', $matches[1]);
        if ($youTubeMatch || $vimeoMatch) {
            $extra = ' frameborder="0"';
            if ($youTubeMatch) {
                $extra .= ' allowfullscreen';
            } elseif ($vimeoMatch) {
                $extra .= ' webkitAllowFullScreen mozallowfullscreen allowFullScreen';
            }
            return '<iframe '.$matches[1].$extra.'></iframe>';
        } else {
            return '';
        }
    }
}
