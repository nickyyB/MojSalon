<?php namespace App\Controllers;

/*
* Autor: Nikola Brkovic
*
* Autor: Petar Jovovic
*/

use App\Models\SalonModel;
use App\Models\UserModel;

class Guest extends BaseController
{
    /*
     * Dohvatanje 4 random salona za preporucene, moze posle top4 najbolje ocenjena --- Nikola
    */
    public function index()
    {
        $db = db_connect();
        $model = new SalonModel($db);
        $salons = $model->getActivesalons();
        shuffle($salons);
        $top4['niz'] = array_slice($salons, 0, 4);
        return view('index', $top4);
    }
    
    /*Test mail funkcionalnosti --- Nikola*/
    public function mail(){
        $to = 'dzony_95@yahoo.com';
        $subject = 'testEmail';
        $message = 'Radi brac';
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setFrom('test123.com');
       
        if($email->send()){
            return view('proba',['errors'=>'DOKTORE']);
        }
        else{
            $data = $email->printDebugger(['headers']);
            return view('proba',['errors'=>$data]);
        }
    }
    
    /* Pregistracije salona --- Nikola */
    public function regSalon(){
        if($this->request->getMethod()=='post'){
            $rules = [
                'name' => 'trim|required|max_length[64]',
                'adress' => 'trim|required|max_length[64]',
                'state' => 'required',
                'pib' => 'required|numeric|exact_length[9]',
                'email' => 'required|valid_email|is_unique[korisnik.email]',
                'username' => 'required|min_length[5]|max_length[15]|username_check_blank|special_chars|is_unique[korisnik.kIme]',
                'password' => 'required|min_length[5]|max_length[15]',
                'password2' => 'matches[password]',
                'phone' => 'required|numeric|min_length[8]|max_length[12]|symbol_check',
                'logo' => 'uploaded[logo]|is_image[logo]|max_size[logo,64]',
                'MondayFrom' => 'required_with[mon]',
                'MondayTo' => 'required_with[mon]|',
                'mon' => 'if_exist|workingHours['.$this->request->getVar('MondayFrom').','.$this->request->getVar('MondayTo').']',
                'TuesdayFrom' => 'required_with[tue]',
                'TuesdayTo' => 'required_with[tue]',
                'tue' => 'if_exist|workingHours['.$this->request->getVar('TuesdayFrom').','.$this->request->getVar('TuesdayTo').']',
                'WednesdayFrom' => 'required_with[wed]',
                'WednesdayTo' => 'required_with[wed]',
                'wed' => 'if_exist|workingHours['.$this->request->getVar('WednesdayFrom').','.$this->request->getVar('WednesdayTo').']',
                'ThursdayFrom' => 'required_with[thu]',
                'ThursdayTo' => 'required_with[thu]',
                'thu' => 'if_exist|workingHours['.$this->request->getVar('ThursdayFrom').','.$this->request->getVar('ThursdayTo').']',
                'FridayFrom' => 'required_with[fri]',
                'FridayTo' => 'required_with[fri]',
                'fri' => 'if_exist|workingHours['.$this->request->getVar('FridayFrom').','.$this->request->getVar('FridayTo').']',
                'SaturdayFrom' => 'required_with[sat]',
                'SaturdayTo' => 'required_with[sat]',
                'sat' => 'if_exist|workingHours['.$this->request->getVar('SaturdayFrom').','.$this->request->getVar('SaturdayTo').']',
                'SundayFrom' => 'required_with[sun]',
                'SundayTo' => 'required_with[sun]',
                'sun' => 'if_exist|workingHours['.$this->request->getVar('SundayFrom').','.$this->request->getVar('SundayTo').']',
            ];
            
            $errors = [
                'name' => [
                  'required' => 'Naziv salona je obavezno polje'  
                ],
                'adress' => [
                  'required' => 'Adresa je obavezno polje'  
                ],
                'state' =>[
                  'required' => 'Opština je obavezno polje'  
                ],
                'pib' => [
                  'required' => 'PIB je obavezno polje',
                  'numeric' => 'PIB sadrži samo cifre',
                  'exact_length' => 'PIB sadrži tacno 9 cifara'
                ],
                'email' => [
                    'required' => 'Email je obavezno polje',
                    'valid_email' => 'Unesite validnu email adresu',
                    'is_unique' => 'Već postoji nalog sa tom email adresom'
                ],
                'username' => [
                    'required' => 'Korisničko ime je obavezno polje',
                    'min_length' => 'Korisničko ime mora imati od 5 do 15 karaktera',
                    'max_length' => 'Korisničko ime mora imati od 5 do 15 karaktera',
                    'is_unique' => 'Već postoji nalog sa tim korisničkim imenom'
                ],
                'password' => [
                    'required' => 'Šifra je obavezno polje',
                    'min_length' => 'Šifra mora imati od 5 do 15 karaktera',
                    'max_length' => 'Šifra mora imati od 5 do 15 karaktera',
                ],
                'password2' => [
                    'matches' => 'Šifra i ponovljena šifra se ne poklapaju'
                ],
                'phone' => [
                    'required' => 'Kontakt telefon je obavezno polje',
                    'numeric' => 'Broj telefona mora sadržati samo cifre',
                    'min_length' => 'Broj telefona mora sadržati izmedju 8 i 12 cifara',
                    'max_length' => 'Broj telefona mora sadržati izmedju 8 i 12 cifara'
                ],
                'logo' => [
                    'uploaded' => 'Molimo dodajte validnu sliku logo-a',
                    'is_image' => 'Logo firme je obavezno polje',
                    'max_size' => 'Maksimalna dozvoljena veličina 64 KB'
                ],
                'mon' => [
                    'workingHours' => 'Greška PONEDELJAK: Vreme zatvaranja mora biti posle vremena otvaranja'
                ],
                'tue' => [
                    'workingHours' => 'Greška UTORAK: Vreme zatvaranja mora biti posle vremena otvaranja'
                ],
                'wed' => [
                    'workingHours' => 'Greška SREDA: Vreme zatvaranja mora biti posle vremena otvaranja'
                ],
                'thu' => [
                    'workingHours' => 'Greška ČETVRTAK: Vreme zatvaranja mora biti posle vremena otvaranja'
                ],
                'fri' => [
                    'workingHours' => 'Greška PETAK: Vreme zatvaranja mora biti posle vremena otvaranja'
                ],
                'sat' => [
                    'workingHours' => 'Greška SUBOTA: Vreme zatvaranja mora biti posle vremena otvaranja'
                ],
                'sun' => [
                    'workingHours' => 'Greška NEDELJA: Vreme zatvaranja mora biti posle vremena otvaranja'
                ],
            ];
            
            
            if(!$this->validate($rules, $errors)){
                return view('/registration/salon', ['errors' => $this->validator->getErrors()]);
            }
            $db = db_connect();
            $model = new UserModel($db);
            
            $generalUser['email'] = $this->request->getVar('email');
            $generalUser['kIme']=$this->request->getVar('username');
            $generalUser['lozinka']=$this->request->getVar('password');
            $generalUser['telefon']=$this->request->getVar('phone');
            $basicUser['naziv']=$this->request->getVar('name');
            $basicUser['adresa']=$this->request->getVar('adress');
            $basicUser['opstina']=$this->request->getVar('state');
            $basicUser['PIB']=$this->request->getVar('pib');
            $basicUser['logo'] = file_get_contents($this->request->getFile('logo'));
            $basicUser['ekstenzija'] = $this->request->getFile('logo')->getMimeType();
            
            $workingHours['mon'] = $this->request->getVar('mon');
            $workingHours['monFrom'] = $this->request->getVar('MondayFrom');
            $workingHours['monTo'] = $this->request->getVar('MondayTo');
            $workingHours['tue'] = $this->request->getVar('tue');
            $workingHours['tueFrom'] = $this->request->getVar('TuesdayFrom');
            $workingHours['tueTo'] = $this->request->getVar('TuesdayTo');
            $workingHours['wed'] = $this->request->getVar('wed');
            $workingHours['wedFrom'] = $this->request->getVar('WednesdayFrom');
            $workingHours['wedTo'] = $this->request->getVar('WednesdayTo');
            $workingHours['thu'] = $this->request->getVar('thu');
            $workingHours['thuom'] = $this->request->getVar('ThursdayFrom');
            $workingHours['thuTo'] = $this->request->getVar('ThursdayTo');
            $workingHours['fri'] = $this->request->getVar('fri');
            $workingHours['FridayFrom'] = $this->request->getVar('FridayFrom');
            $workingHours['FridayTo'] = $this->request->getVar('FridayTo');
            $workingHours['sat'] = $this->request->getVar('sat');
            $workingHours['SaturdayFrom'] = $this->request->getVar('SaturdayFrom');
            $workingHours['SaturdayTo'] = $this->request->getVar('SaturdayTo');
            $workingHours['sun'] = $this->request->getVar('sun');
            $workingHours['SundayFrom'] = $this->request->getVar('SundayFrom');
            $workingHours['SundayTo'] = $this->request->getVar('SundayTo');
            
            $model->addSalonUser($generalUser, $basicUser, $workingHours);
            return view('/registration/login', ['message'=>'Uspešno ste poslali zahtev za registraciju, admin će obraditi Vaš zahtev u što kraćem roku.']);
        }
        return view('/registration/salon');
    }
    
    /* Registracije korisnika --- Nikola */
    public function regUser(){
        if($this->request->getMethod() == 'post'){
            
            $rules = [
                'email' => 'required|valid_email|is_unique[korisnik.email]',
                'username' => 'trim|required|min_length[5]|max_length[15]|username_check_blank|special_chars|is_unique[korisnik.kIme]',
                'password' => 'trim|required|min_length[5]|max_length[15]',
                'password2' => 'trim|matches[password]',
                'name' => 'permit_empty|alpha_space|max_length[20]',
                'surname' => 'permit_empty|alpha_space|max_length[20]',
                'phone' => 'permit_empty|numeric|min_length[8]|max_length[12]|symbol_check',
                'bday' => 'check_date'
            ];
        
            $errors = [
                'email' => [
                    'required' => 'Email je obavezno polje',
                    'valid_email' => 'Unesite validnu email adresu',
                    'is_unique' => 'Vec postoji nalog sa tom email adresom'
                ],
                'username' => [
                    'required' => 'Korisničko ime je obavezno polje',
                    'min_length' => 'Korisničko ime mora imati od 5 do 15 karaktera',
                    'max_length' => 'Korisničko ime mora imati od 5 do 15 karaktera',
                    'is_unique' => 'Vec postoji nalog sa tim korisničkim imenom'
                ],
                'password' => [
                    'required' => 'Šifra je obavezno polje',
                    'min_length' => 'Šifra mora imati od 5 do 15 karaktera',
                    'max_length' => 'Šifra mora imati od 5 do 15 karaktera',
                ],
                'password2' => [
                    'matches' => 'Šifra i ponovljena šifra se ne poklapaju'
                ],
                'name' => [
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
            
            if(!$this->validate($rules, $errors)){
                return view('/registration/basicUser', ['errors' => $this->validator->getErrors()]);
            }
            $db = db_connect();
            $model = new UserModel($db);
            
            $generalUser['email'] = $this->request->getVar('email');
            $generalUser['kIme']=$this->request->getVar('username');
            $generalUser['lozinka']=$this->request->getVar('password');
            $generalUser['telefon']=$this->request->getVar('phone');
            $generalUser['stanje']=1;
            $basicUser['ime']=$this->request->getVar('name');
            $basicUser['prezime']=$this->request->getVar('surname');
            $basicUser['pol']=$this->request->getVar('gender');
            $basicUser['datumR']=$this->request->getVar('bday');
            $basicUser['opstina']=$this->request->getVar('state');
            
            $model->addBasicUser($generalUser, $basicUser);
            return view('/registration/login', ['message'=>'Uspešno ste se registrovali. Ulogujte se sa vasim kredencijalima.']);
        }
        return view('/registration/basicUser');
    }

    
    /* Login skripta --- Nikola */
    public function login(){
        if($this->request->getMethod()=='post'){
                    
            $rules = [
              'username' => 'required',
              'password' => 'required'
            ];

            $errors = [
                'username' => [
                    'required' => 'Korisničko ime/email je obavezno polje!'
                ],
                'password' => [
                    'required' => 'Morate uneti vašu lozinku.'
                ]
            ];

            if(!$this->validate($rules,$errors)){
                return view('/registration/login', ['errors' => $this->validator->getErrors()]);
            }

            $db = db_connect();
            $model = new UserModel($db);
            $username = $this->request->getVar('username');
            $user = $model->getUser($username);

            if($user == null){
                $message['poruka'] = 'Proverite korisničko ime/email';
                return view('/registration/login', ['errors' => $message]);
            }
            if($user->lozinka != $this->request->getVar('password')){
                $message['poruka'] = 'Neispravna šifra';
                return view('/registration/login', ['errors' => $message]);
            }

            $controller = $model->getTypeOfUser($user);
 
            session()->set('user', $user);
            session()->set('controller', $controller);
            return redirect()->to(site_url($controller));
        }
        return view('/registration/login');
    }
    
    /* Pretraga salona stranica --- Nikola */
    public function searchSalons(){
        $db = db_connect();
        $model = new SalonModel($db);
        $services = $model->getTypeOfServices();
        return view('search', ['services' => $services]);
    }
    
    /* Pretraga skripta --- Nikola */
    public function search(){
        $db = db_connect();
        $model = new SalonModel($db);
        
        $limit = 5;  
        $page = $this->request->getVar('page');
        if($page==0) $page=1;
        $state = $this->request->getVar('state');
        $type = $this->request->getVar('type');
        $price = explode('|', $this->request->getVar('price'));
        if($price[1]=='max') $price[1]=999999;
        $salons=$model->getSalonByName($this->request->getVar('search'), $limit, $limit*($page-1), $state, $type, $price[0], $price[1]);
        return json_encode($salons);
    }
    
    public function salon($id = 0){
        $db = db_connect();
        $model = new SalonModel($db);

        $services = $model->getSalonServices($id);
        $salon = $model->getSalonById($id);
        $workingHrs = $model->getWorkingHrs($id);
        $comments = $model->getComments($id);
        $rating = $model->getRating($comments);
        $images = $model->getGallery($id);

        return view("salon", ['usluge' => $services, 'salon' => $salon[0], 'workingHrs' => $workingHrs[0], 'comments' => $comments, 'rating' => $rating, 'images'=>$images]);
    }


    public function salonActive($id = 0){
        $db = db_connect();
        $model = new SalonModel($db);

        $services = $model->getSalonServices($id);
        $salon = $model->getSalonById($id);

        return view("salon_active", ['usluge' => $services, 'salon' => $salon[0]]);
    }
    /* Prikaz stranice koja potvrdjuje poslat mail --- Petar */
    public function email_conf_page_Guest(){
        $db = db_connect();
        $model = new SalonModel($db);
        $data['supp']=0;
        
        
        return view('confirmedMailGuest',[]);
    }

    /* Gost slanje maila --- Petar*/
    public function send_mail_guest(){
        $to = 'techsuppsalon@gmail.com';
        $subject = 'testEmail';
        $message = $this->request->getVar('message');
        $subject = $this->request->getVar('email');
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setFrom('psisalonteam123@gmail.com');
        $rules = [
            'message' => 'required',
            'email' => 'required|valid_email',
            'name' => 'required|alpha_space|max_length[20]'
            
        ];

        $errors = [
            'message' => [
                'required' => 'Poruka ne sme biti prazna'

                
            ],
            'email' => [
                'required' => 'Email je obavezno polje',
                'valid_email' => 'Unesite validnu email adresu',
                
            ],
            'name' => [
                'required' => 'Ime je obavezno polje',
                'alpha_space' => 'Ime mora sadržati samo slova',
                'max_length' => 'Ime može imati maksimalno 20 karaktera'
            ]
        ];
        
        if(!$this->validate($rules, $errors)){
            $db = db_connect();
            $model = new SalonModel($db);
            $salons = $model->getActivesalons();
            shuffle($salons);
           
            
            $top4['niz'] = array_slice($salons, 0, 4);
            $top4['errors'] = $this->validator->getErrors();
            
        
            return view("index", $top4);
        }
        else{
            if($email->send()){
                return redirect()->to(site_url('Guest/email_conf_page_Guest'));   
            }
            else{
                $data = $email->printDebugger(['headers']);
                return view('proba',['errors2'=>$data]);
            }
        }
    }
    
}
