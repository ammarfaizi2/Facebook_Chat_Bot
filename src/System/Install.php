<?php
namespace System;

/**
*	@author Ammar Faizi <ammarfaizi2@gmail.com>
*/
class Install
{
    public function __construct()
    {
        file_exists(__DIR__.'/../../de/install.zip') or die("Installer not found !");
        require __DIR__.'/../../PCLZip.php';
        $this->hash = array(
                (file_get_contents(__DIR__.'/../../de/hash.txt'))=>__DIR__.'/../../vendor/ammarfaizi2/ins.hash',
            );
        $this->pclzip = new \PCLZip(__DIR__.'/../../de/install.zip');
    }
    public function is_installed()
    {
        $status = true;
        foreach ($this->hash as $key => $val) {
            if (!file_exists($val) or file_get_contents($val)!=$key) {
                $status = false;
                break;
            }
        }
        return $status;
    }
    private function save_hash()
    {
        foreach ($this->hash as $key => $value) {
            file_put_contents($value, $key);
        }
    }
    public function install()
    {
        $this->pclzip->extract(PCLZIP_OPT_PATH, __DIR__.'/../../vendor');
        $this->save_hash();
    }
}