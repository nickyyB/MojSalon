<?php

/*
 * Autor: Nikola Brkovic 0647/2014
 *
 */

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session=session();
        if(!$session->has('user')){
            return redirect()->to(site_url('Guest'));
        }
        if($session->get('controller')!='User'){
            return redirect()->to(site_url($session->get('controller')));
        }
            
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
