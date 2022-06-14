<?php

namespace App\Controllers;
/*
 * Autor:Petar Jovovic 0352/19
 *

* Autor: Danica Jakovljevic 0305/2019

* Autor: Nikola Brkovic 0647/2014

*/



use App\Models\SalonModel;
use App\Models\UserModel;
use DateTime;
use PhpParser\Node\Stmt\Echo_;


class User extends BaseController
{
    /*Sablon za prikazivanje stranica --- Nikola*/
    protected function prikaz($page, $data)
    {
        $data['controller'] = session()->get('controller');
        $data['user'] = session()->get('user');
        $data['method'] = $this->getRouter();
        return view($page, $data);
    }

    /*index funkcija dohvata sve aktivne salone i vraca random 4 za pocetnu stranu,
        mozemo ovo promeniti da vraca 4 najbolje ocenjena kasnije kad se resi ocenjivanje
     * Nikola
    */
    public function index()
    {
        $db = db_connect();
        $model = new SalonModel($db);

        $salons = $model->getActivesalons();
        shuffle($salons);
        $data['niz'] = array_slice($salons, 0, 4);
        return $this->prikaz('userProfile/index_user', $data);
    }

    /*Logout skripta --- Nikola*/
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url());
    }

    /**Prikaz termina --- Danica*/
    public function appointments()
    {
        $db = db_connect();
        $model = new UserModel($db);
        $userId = session()->get('user')->idKorisnik;
        $data['appointments'] = $model->paginate($userId, 5);
        $data['pager'] = $model->pager;
        return $this->prikaz('/userProfile/appointments', $data);
    }

    /**Ocenjivanje usluge --- Danica*/
    public function review($appointmentId = NULL)
    {
        $data['appointmentId'] = $appointmentId;
        $data['comment'] = $this->request->getPost('comment');
        $data['rating'] = $this->request->getPost('rating');
        $data['errorMessage'] = "";

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'rating' => 'required'
            ];

            $errors = [
                'rating' => [
                    'required' => 'Morate uneti ocenu'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data['errors'] = $this->validator->getErrors();
                return $this->prikaz('/userProfile/review', $data);
            } else {

                $db = db_connect();
                $model = new UserModel($db);
                if (!$model->insertReview($appointmentId, $data['rating'], $data['comment'])) {
                    $data['errorMessage'] = "Došlo je do greške sa bazom podataka.";
                } else {
                    $salonModel = new SalonModel($db);
                    $service = $salonModel->getServiceById($model->getAppointmentById($appointmentId)[0]->idUsluga);
                    return redirect()->to(site_url("/User/salon/{$service->idSalon}"));
                }
            }
        }
        return $this->prikaz('/userProfile/review', $data);
    }

    /**Prikaz statusa korisnika -- Danica */
    public function status()
    {
        $db = db_connect();
        $model = new UserModel($db);

        $userId = session()->get('user')->idKorisnik;
        $count = $model->getAppointmentCountForUserStatus($userId);
        if ($count >= 50) {
            $data['status'] = "Zlatnog";
            $data['discount'] = 15;
            $data['next_count'] = null;
            $data['next_status'] = null;
        } elseif ($count >= 25) {
            $data['status'] = "Srebrnog";
            $data['discount'] = 10;
            $data['next_count'] = 50;
            $data['next_status'] = "Zlatni";
        } elseif ($count >= 10) {
            $data['status'] = "Bronzanog";
            $data['discount'] = 5;
            $data['next_count'] = 25;
            $data['next_status'] = "Srebrni";
        } else {
            $data['status'] = null;
            $data['discount'] = null;
            $data['next_count'] = 10;
            $data['next_status'] = "Bronzani";
        }
        $data['count'] = $count;

        return $this->prikaz('/userProfile/status', $data);
    }

    /**Otkazivanje termina --- Danica */
    public function cancel($appointmentId = NULL)
    {
        $db = db_connect();
        $model = new UserModel($db);
        $model->cancelAppointment($appointmentId);
        return redirect()->to("User/appointments");
    }

    /**Zakazivanje termina  stranica--- Danica */
    public function makeAppointment($serviceId = NULL)
    {
        $db = db_connect();
        $model = new SalonModel($db);
        $data['service'] = $model->getServiceById($serviceId);
        $data['salon'] = ($model->getSalonById($data['service']->idSalon))[0];
        $userModel = new UserModel($db);
        $count = $userModel->getAppointmentCountForUserStatus(session()->get('user')->idKorisnik);
        if ($count >= 50) {
            $data['discount'] = 15;
        } elseif ($count >= 25) {
            $data['discount'] = 10;
        } elseif ($count >= 10) {
            $data['discount'] = 5;
        } else {
            $data['discount'] = null;
        }
        return $this->prikaz('/userProfile/makeAppointment', $data);
    }

    /**Ubacivanje termina u bazu skripta --- Danica */
    public function insertAppointment()
    {
        $db = db_connect();
        $model = new UserModel($db);
        $datetime = $this->request->getVar('datetime');
        $serviceId = $this->request->getVar('serviceId');
        $userId = session()->get('user')->idKorisnik;
        $count = $model->getAppointmentCountForUserStatus(session()->get('user')->idKorisnik);
        if ($count >= 50) {
            $discount = 15;
        } elseif ($count >= 25) {
            $discount = 10;
        } elseif ($count >= 10) {
            $discount = 5;
        } else {
            $discount = null;
        }
        $result = $model->insertAppointment($userId, $serviceId, $datetime, $discount);
        return json_encode($result);
    }

    /**Zakazivanje prikaz vremena skripta --- Danica  */
    public function timetable()
    {
        $db = db_connect();
        $model = new SalonModel($db);
        $serviceId = $this->request->getVar('serviceId');
        $day = $this->request->getVar('day');
        $times = $model->getFreeSlots($serviceId, $day);
        return json_encode($times);
    }

    /* Pretraga salona stranica --- Nikola */

    public function searchSalons()
    {
        $db = db_connect();
        $model = new SalonModel($db);
        $model2 = new UserModel($db);
        $data['services'] = $model->getTypeOfServices();
        $data['opstina'] = $model2->getState(session()->get('user'));
        return $this->prikaz('search', $data);
    }

    /* Pretraga skripta --- Nikola */
    public function search()
    {
        $db = db_connect();
        $model = new SalonModel($db);

        $limit = 5;
        $page = $this->request->getVar('page');
        if ($page == 0) $page = 1;
        $state = $this->request->getVar('state');
        $type = $this->request->getVar('type');
        $price = explode('|', $this->request->getVar('price'));
        if ($price[1] == 'max') $price[1] = 999999;
        $salons = $model->getSalonByName($this->request->getVar('search'), $limit, $limit * ($page - 1), $state, $type, $price[0], $price[1]);
        return json_encode($salons);
    }


    public function changeProfile()
    {
        $db = db_connect();
        $model = new UserModel($db);
        $user = session()->get('user');
        $data['podaci'] = $model->getUserData($user->kIme);

        return $this->prikaz("userProfile/izmena_profila", $data);
    }
    /* Promena profila korisnika --- Petar */
    public function change_data()
    {
        $name =  $this->request->getVar('name');
        $surname = $this->request->getVar('surname');
        $munc =  $this->request->getVar('munc');

        $phone =  $this->request->getVar('phone');


        $korisnik = session()->get('user');

        $db = db_connect();
        $model = new UserModel($db);

        //$email_pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $rules = [
            'name' => 'permit_empty|alpha_space|max_length[20]',
            'surname' => 'permit_empty|alpha_space|max_length[20]',
            'phone' => 'permit_empty|numeric|min_length[8]|max_length[12]',
            
        ];

        $errors = [

            'name' => [
                'required' => 'Ime je obavezno polje',
                'alpha_space' => 'Ime mora sadržati samo slova',
                'max_length' => 'Ime može imati maksimalno 20 karaktera'
            ],
            'surname' => [
                'alpha_space' => 'Prezime mora sadržati samo slova',
                'max_length' => 'Prezime može imati maksimalno 20 karaktera'
            ],
            'phone' => [
                
                'numeric' => 'Broj telefona mora sadrzati samo cifre',
                'min_length' => 'Broj telefona mora sadrzati izmedju 8 i 12 cifara',
                'max_length' => 'Broj telefona mora sadrzati izmedju 8 i 12 cifara'

            ]
            
        ];

        if (!$this->validate($rules, $errors)) {
            $db = db_connect();
            $model = new UserModel($db);
            $user = session()->get('user');
            $data['podaci'] = $model->getUserData($user->kIme);
            $data['errors'] = $this->validator->getErrors();

            return $this->prikaz("userProfile/izmena_profila", $data);
        } else {

            $model->changeUserData($korisnik->idKorisnik,  $phone, $name, $surname, $munc);
            return redirect()->to(site_url('/User/changeProfile'));
        }

        /*if (
            empty($this->request->getVar('name')) || empty($this->request->getVar('surname')) || empty($this->request->getVar('phone'))  
            || empty($this->request->getVar('munc')) )
         {
            echo "Greska";
        } else {

            $model->changeUserData($korisnik->idKorisnik,  $phone, $name, $surname, $munc);
            return redirect()->to(site_url('/User/changeProfile'));
        }*/
    }


    /* Prikaz support stranice usera --- Petar */
    public function support_page()
    {
        $db = db_connect();
        $model = new SalonModel($db);
        $salon = session()->get('user');
        $data['supp'] = $model->getUserById($salon->idKorisnik)[0];

        return $this->prikaz('userProfile/user_support', $data);
    }

    /* Prikaz stranice koja potvrdjuje da je poslat mail --- Petar */
    public function email_conf_page_user()
    {
        $db = db_connect();
        $model = new SalonModel($db);
        $salon = session()->get('user');
        $data['supp'] = $model->getUserById($salon->idKorisnik)[0];

        return $this->prikaz('userProfile/confirmedMailUser', $data);
    }


    public function salon($id = 0)
    {
        $db = db_connect();
        $model = new SalonModel($db);

        $services = $model->getSalonServices($id);
        $salon = $model->getSalonById($id);
        $workingHrs = $model->getWorkingHrs($id);
        $comments = $model->getComments($id);
        $rating = $model->getRating($comments);
        $images = $model->getGallery($id);

        return $this->prikaz("userProfile/salon_active", ['usluge' => $services, 'salon' => $salon[0], 'workingHrs' => $workingHrs[0], 'comments' => $comments, 'rating' => $rating, 'images' => $images]);
    }


    public function send_mail_user()
    {
        $to = 'techsuppsalon@gmail.com';
        $subject = $userId = session()->get('user')->email;
        $message = $this->request->getVar('message');
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setFrom('psisalonteam123@gmail.com');
        $rules = [
            'message' => 'required'

        ];

        $errors = [
            'message' => [
                'required' => 'Poruka ne sme biti prazna',

            ]
        ];

        if (!$this->validate($rules, $errors)) {
            $errs = $this->validator->getErrors();
            $db = db_connect();
            $model = new UserModel($db);
            $user = session()->get('user');

            $data['errors'] = $errs;

            return $this->prikaz("user_support", $data);
        } else {
            if ($email->send()) {
                return redirect()->to(site_url('User/email_conf_page_user'));
            } else {

                $data = $email->printDebugger(['headers']);
                return view('proba', ['errors2' => $data]);
            }
        }
    }
}
