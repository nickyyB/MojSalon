<?php 

/*
* Autor: Mihajlo Micic
* 
* Autor: Nikola Brkovic
*/
namespace App\Controllers;

use App\Models\SalonModel;
use App\Models\UserModel;

class Admin extends BaseController {
    
    /*Sablon za prikazivanje stranica --- Nikola*/
    protected function prikaz($page, $data){
        $data['controller']=session()->get('controller');
        $data['user']=session()->get('user');
        $data['method']=$this->getRouter();
        return view('adminProfile/'.$page, $data);
    }
    
    /*Logout skripta --- Nikola*/
    public function logout(){
        session()->destroy();
        return redirect()->to(site_url());
    }
    
    /*Pocetni prikaz admina --- Mihajlo*/
    public function index(){
        $db = db_connect();
        $model = new UserModel($db);
        //dohvati sta treba za pocetnu pa prosledi u okviru data
        $users = $model->getActiveUsers();
        return $this->prikaz('admin_manageUser', ['users' => $users]);
    }


    public function activesalons(){
        $db = db_connect();
        $model = new SalonModel($db);

        $salons = $model->getActivesalons();
        return $this->prikaz('admin_manageSalons', ['salons' => $salons]);
    }
  
    /**
     * pretraga korisnika po korimenu --- Mihajlo
     */
  
    public function users(){
        $query = $this->request->getvar('search');
        $db = db_connect();
        $model = new UserModel($db);

        $data['users'] = $model->searchUsers($query);
        return $this->prikaz('admin_manageUser', $data);
    }

    /**
     * pretraga salona po nazivu --- Mihajlo
     */
    public function salons(){
        $query = $this->request->getvar('search');
        $db = db_connect();
        $model = new SalonModel($db);

        $data['salons'] = $model->searchsalons($query);
        return $this->prikaz('admin_manageSalons', $data);
    }

    /**
     * kombinovati u 1 metod, salji status kao hidden input --- Mihajlo
     */
    public function remove(){
        $query = $this->request->getvar('user');
        $db = db_connect();
        $model = new UserModel($db);
        $model->deleteUser($query);
        return $this->index();
    }

    public function removeBlocked(){
        $query = $this->request->getvar('user');
        $db = db_connect();
        $model = new UserModel($db);
        $model->deleteUser($query);
        return $this->blockedUsers();
    }
    ////////////////////////////////////////////////////

    /**
     * blokiranje i odblokiranje korisnika --- Mihajlo
     */
    public function blockedUsers(){
        $db = db_connect();
        $model = new UserModel($db);
        //dohvati sta treba za pocetnu pa prosledi u okviru data
        $users = $model->getBlockedUsers();
        return $this->prikaz('admin_blockedUsers', ['users' => $users]);
    }

    public function block(){
        $query = $this->request->getvar('user');
        $db = db_connect();
        $model = new UserModel($db);
        $model->blockUser($query);
        return $this->index();
    }

    public function unblock(){
        $query = $this->request->getvar('user');
        $db = db_connect();
        $model = new UserModel($db);
        $model->unblockUser($query);
        return $this->blockedUsers();
    }

    public function searchBlockedUsers(){
        $query = $this->request->getvar('search');
        $db = db_connect();
        $model = new UserModel($db);

        $data['users'] = $model->searchBlockedUsers($query);
        return $this->prikaz('admin_blockedUsers', $data);
    }


    /* Zahtevi za registraciju salona --- Nikola */
    public function regRequest(){
        $db= db_connect();
        $model = new UserModel($db);
        $data['users'] = $model->salonNull();
        return $this->prikaz('admin_regRequestSalon', $data);
    }
    
    /* Prihvatanje zahteva za registraciju salona --- Nikola */
    public function acceptRequest(){
        $db= db_connect();
        $model = new UserModel($db);
        $username = $this->request->getVar('user');
        $model->salonSetStatus($username, 1);
        return $this->regRequest();
    }
    
    /* Odbijanje zahteva za registraciju salona --- Nikola */
    public function rejectRequest(){
        $db= db_connect();
        $model = new UserModel($db);
        $username = $this->request->getVar('user');
        $model->deleteUser($username);
        return $this->regRequest();
    }

    /**
     * prikaz blokiranih salona --- Mihajlo
     */
    
    public function blockedsalons(){
        $db = db_connect();
        $model = new SalonModel($db);
        //dohvati sta treba za pocetnu pa prosledi u okviru data
        $salons = $model->getBlockedsalons();
        return $this->prikaz('admin_blockedSalons', ['salons' => $salons]);
    }
    
    /**
     * brisanje aktivnih i blokiranih salona --- Mihajlo
     */

    public function removesalon(){
        $query = $this->request->getvar('id');
        $db = db_connect();
        $model = new SalonModel($db);
        $model->deleteUser($query);
        return $this->activesalons();
    }

    
    public function removeBlockedsalon(){
        $query = $this->request->getvar('id');
        $db = db_connect();
        $model = new SalonModel($db);
        $model->deleteUser($query);
        return $this->blockedsalons();
    }


    public function blocksalon(){
        $query = $this->request->getvar('id');
        $db = db_connect();
        $model = new SalonModel($db);
        $model->blocksalon($query);
        return $this->activesalons();
    }
    
    public function unblocksalon(){
        $query = $this->request->getvar('id');
        $db = db_connect();
        $model = new SalonModel($db);
        $model->unblocksalon($query);
        return $this->blockedsalons();
    }
    /////////////////////////////////////////////////////////
    

}
