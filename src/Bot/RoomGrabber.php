<?php

namespace Bot;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 2.0.1
 * @license BSD
 */

use Hub\Contracts\BlueFishContract;
use Hub\Abstraction\IlluminateSupply;

class RoomGrabber extends IlluminateSupply implements BlueFishContract
{
    
    /**
     * @var string
     */
    private $src;

    /**
     * @var array
     */
    private $rooms = array();

    /**
     * @param string $src
     */
    public function __construct($src)
    {
        $this->src = $src;
    }

    /**
     * @param int $limit
     */
    private function real_grabber($limit = null)
    {
        $a = explode('<table class=', $this->src);
        $fx = function ($x)
        {
            return trim(html_entity_decode($x, ENT_QUOTES, 'UTF-8'));
        };
        $cc = count($a)-3;
        if ($limit !== null) {
            for ($i=3;$i<$cc;$i++) {
                $c = explode("<a href=\"", $a[$i], 2);
                if (isset($c[1])) {
                    $c = explode("\"", $c[1], 2);
                    $d = explode(">", $c[1], 2);
                    $d = explode("<", $d[1], 2);
                    if (substr($d[0], -1) == ")") {
                        $d[0] = explode("(", $d[0], 2);
                        $d[0] = $d[0][0];
                    }
                    $this->rooms[$fx($d[0])] = $fx($c[0]);
                }
            }
        } else {
            $ll = 0;
            for ($i=3;$i<$cc;$i++) {
                $c = explode("<a href=\"", $a[$i], 2);
                if (isset($c[1])) {
                    $c = explode("\"", $c[1], 2);
                    $d = explode(">", $c[1], 2);
                    $d = explode("<", $d[1], 2);
                    if (substr($d[0], -1) == ")") {
                        $d[0] = explode("(", $d[0], 2);
                        $d[0] = $d[0][0];
                    }
                    $this->rooms[$fx($d[0])] = $fx($c[0]);
                    $ll++;
                }
            }
        }
        var_dump($this->rooms);die;
    }

    /**
     * @param int $limit
     * @return array
     */
    public function __invoke($limit = null)
    {
        $this->real_grabber();
        return $this->rooms;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->src);
    }
}
