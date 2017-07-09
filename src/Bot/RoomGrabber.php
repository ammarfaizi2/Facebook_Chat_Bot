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
        $cc = count($a)-3;
        if ($limit !== null) {
            for ($i=3;$i<$cc;$i++) {
                $c = explode("<a href=\"", $a[$i], 2);
                if (isset($c[1])) {
                    $c = explode("\"", $c[1], 2);
                    $this->rooms[] = html_entity_decode($c[0], ENT_QUOTES, 'UTF-8');
                }
            }
        } else {
            $ll = 0;
            for ($i=3;$i<$cc;$i++) {
                $c = explode("<a href=\"", $a[$i], 2);
                if (isset($c[1])) {
                    $c = explode("\"", $c[1], 2);
                    $this->rooms[] = html_entity_decode($c[0], ENT_QUOTES, 'UTF-8');
                    $ll++;
                }
            }
        }
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
