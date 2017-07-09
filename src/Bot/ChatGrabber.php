<?php

namespace Bot;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 2.0.1
 * @license BSD
 */

use Hub\Contracts\DragonContract;
use Hub\Abstraction\IlluminateSupply;

class ChatGrabber extends IlluminateSupply implements DragonContract
{
    
    /**
     * @var string
     */
    private $src;

    /**
     * @var array
     */
    private $events = array();

    /**
     * @param string $src
     */
    public function __construct($src)
    {
        $this->src = $src;
    }

    /**
     * Parse Event
     */
    private function parseEvents()
    {
        $fx = function ($str) {
            return trim(str_replace("<br />", "\n", html_entity_decode($str, ENT_QUOTES, 'UTF-8')));
        };
        $a = explode('<div id="messageGroup">', $this->src, 2);
        $a = explode('<form method="post"', $a[1], 2);
        $a = explode('<div>', $a[0], 2);
        $b = explode('>', $a[1]);
        $b = $b[0];
        $a = explode($b, $a[1]);
        $b = explode('>', $a[1], 5);
        $b = $b[3].'>';
        $count_a = count($a);
        for ($i=1;$i<$count_a;$i++) {
            $c = explode($b, $a[$i], 2);
            if (isset($c[1])) {
                $c = explode('</strong>', $c[1], 2);
                $name = trim($fx($c[0]));
                $c = explode("<span>", $c[1]);
                $count_c = count($c);
                $f = array();
                for ($j=0;$j<$count_c;$j++) {
                    if (strpos($c[$j], "<abbr>")!==false) {
                        break;
                    } else {
                        $e = trim(strip_tags($fx($c[$j])));
                        !empty($e) and $f[] = $e;
                    }
                }
                if (count($f)) {
                    $this->events[] = array(
                    "name" => $name,
                    "messages" => $f
                    );
                }
            }
        }
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        $this->parseEvents();
        return $this->events;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->src);
    }
}
