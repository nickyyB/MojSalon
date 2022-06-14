<?php namespace App\Controllers;

/*
* Autor: Nikola Brkovic 0647/2014
*
* Autor: Mihajlo Micic 0565/2017
*/

use App\Models\SalonModel;
use App\Models\UserModel;

class Salon extends BaseController {
    
    /*Sablon za prikazivanje stranica --- Nikola*/
    protected function prikaz($page, $data){
        $db = db_connect();
        $model = new SalonModel($db);

        $data['controller']=session()->get('controller');
        $data['user']=session()->get('user');
        $data['method']=$this->getRouter();
        return view('salonProfile/'.$page, $data);
    }
    
    /*Logout skripta --- Nikola*/
    public function logout(){
        session()->destroy();
        return redirect()->to(site_url());
    }
    
    /*Pocetni prikaz admina*/
    public function index()
    {
        //dohvati sta treba za pocetnu pa prosledi u okviru data
        $data=[];
        return $this->offer_page();
    }

    public function changeProfile(){
        $db = db_connect();
        $model = new SalonModel($db);
        $user=session()->get('user');
        $data['salon']=$model->getSalon($user)[0];/// OVO IMPLEMENTIRATI
        return $this->prikaz('salon_info', $data);
    }



    public function change_data(){


        $name =  $this->request->getVar('name');
        $address = $this->request->getVar('address');
        $munc =  $this->request->getVar('munc');
        $phone =  $this->request->getVar('phone');
        

        $salon = session()->get('user');

        $db = db_connect();
        $model = new SalonModel($db);

        //$email_pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $rules = [
            
            'name' => 'trim|required|max_length[64]',
            'address' => 'trim|required|max_length[64]',
            'phone' => 'required|numeric|min_length[8]|max_length[12]|symbol_check',
            'munc' => 'required'
        ];
    
        $errors = [
            
            'name' => [
                'required' =>'Naziv salona je obavezno polje',
                'max_length' => 'Ime može imati maksimalno 64 karaktera'
            ],
            'address' => [
                'required' =>'Adresa je obavezno polje',
                'max_length' => 'Adresa može imati maksimalno 64 karaktera'
            ],
            'phone' => [
                'required' => 'Broj telefona je obavezno polje',
                'numeric' => 'Broj telefona mora sadrzati samo cifre',
                'min_length' => 'Broj telefona mora sadrzati izmedju 8 i 12 cifara',
                'max_length' => 'Broj telefona mora sadrzati izmedju 8 i 12 cifara'
            ],
            'munc' => [
                'required' => 'Morate odabrati opštinu kojoj salon pripada.'
            ]
            
        ];
        
        if(!$this->validate($rules, $errors)){
            $db = db_connect();
            $model = new SalonModel($db);
            $user = session()->get('user');
            $data['salon'] = $model->getSalon($user)[0];
            $data['errors'] = $this->validator->getErrors();

            return $this->prikaz("salon_info", $data);
            
           
        }
        else {

            $model->changeUserData($salon->idKorisnik,$phone,$name,$address,$munc);
            $data['success'][0] = "Uspešno ste izmenili podatke!";
            $data['usluge']=$model->getSalonServices($salon->idKorisnik);
            return $this->prikaz("salonOfferPage", $data);
            //return redirect()->to(site_url('Salon'));
        }
    }
    
    /* Prikaz stranice koja sadrzi sve rezervacije salona --- Petar */
    public function confirmation_page(){
        $db = db_connect();
        $model = new SalonModel($db);
        $salon=session()->get('user');
        $data['termini']=$model->getNonConfAppointments($salon->idKorisnik);
        return $this->prikaz("salon_manageAppointments",$data);
    }

    /* Prikaz stranice koja sadrzi sve rezervacije salona po imenu korisnika --- Petar */
    public function confirmation_page_byName(){
        
        
        if(empty($this->request->getVar('searchUser'))){
            return redirect()->to(site_url('Salon/confirmation_page'));

        }

        else{
            $db = db_connect();
            $model = new SalonModel($db);
            $salon=session()->get('user');
            $user =  $this->request->getVar('searchUser');
            
            $data['termini']=$model-> getAppointsByUser($salon->idKorisnik, $user);
            return $this->prikaz("salon_manageAppointments",$data);

        }
        

    }
    /* Potrvda rezervacije --- Petar */
    public function acceptAppointment(){
        $id =$this->request->getVar('id');
        
        
        
        $db = db_connect();
        $model = new SalonModel($db);
        $model->acceptAppoint($id);
        #return $this->confirmation_page();
        return redirect()->to(site_url('Salon/confirmation_page'));
    }

    /* Odbijanje rezervacije --- Petar */
    public function denyAppointment(){
        $id =  $this->request->getVar('id');
        
       
        
        $db = db_connect();
        $model = new SalonModel($db);
        $model->denyAppoint($id);
        //return $this->index();
        #return $this->confirmation_page();
        return redirect()->to(site_url('salon/confirmation_page'));
    }
    /* Prikaz support stranice salona --- Petar */
    public function support_page(){
        $db = db_connect();
        $model = new SalonModel($db);
        $salon=session()->get('user');
        $data['supp']=$model->getUserById($salon->idKorisnik)[0];
       
        
        return $this->prikaz('salon_support',$data);
    }
    /* Prikaz stranice koja sadrzi celokupnu ponudu salona --- Petar */
    public function offer_page(){
        $db = db_connect();
        $model = new SalonModel($db);
        $salon=session()->get('user');
        $data['usluge']=$model->getSalonServices($salon->idKorisnik);
        return $this->prikaz("salonOfferPage",$data);
    }

    /* Prikaz stranice za izmenu odredjene usluge --- Petar */
    public function serviceChangePage($idUsluga){
        
        $db = db_connect();
        $model = new SalonModel($db);

        $salon=session()->get('user');
        $data['u_podaci']=$model->getServiceAndType($idUsluga)[0];
        $data['tipovi'] = $model->getAllTypes();
        return $this->prikaz("serviceChange",$data);

    }

    /* Menjanje usluge salona --- Petar */
    function saveServiceChanges($idUsluga){
        $name =  $this->request->getVar('name');
        $cena= $this->request->getVar('cena');
        $trajanje =  $this->request->getVar('trajanje');
        $tip = $this->request->getVar('tip');
        
       
        $db = db_connect();
        $model = new SalonModel($db);
        $tip_id = $model->getTypeIdbyName($tip)[0]->idTip;
        $rules = [
            
            'name' => 'required|max_length[40]',
            
            'cena' => 'required|numeric|max_length[8]|greater_than[0]',
            'trajanje'=>'required|numeric|max_length[3]|greater_than[0]'
        ];
    
        $errors = [
            
            'name' => [
                'required' =>'Ime je obavezno polje',
                
                'max_length' => 'Ime usluge može imati maksimalno 40 karaktera'
            ],
            'trajanje' => [
                'required' =>'Trajanje je obavezno polje',
                'numeric' => 'Trajanje termina mora sadrzati samo cifre',
                'max_length' => 'Trajanje može imati maksimalno 3 cifre(minuti)'
                
                
            ],
            'cena' => [
                'required' =>'Cena je obavezno polje',
                'numeric' => 'Cena mora sadrzati samo cifre',
                'greater_than' => 'Cena mora biti pozitivan broj',
                'max_length' => 'Cena mora sadrzati maksimalno 8 cifara'
            ]
            
        ];
       
        
        
        if(!$this->validate($rules, $errors)){
            $db = db_connect();
            $model = new SalonModel($db);
    
            $salon=session()->get('user');
            $data['u_podaci']=$model->getServiceAndType($idUsluga)[0];
            $data['tipovi'] = $model->getAllTypes();
            
            
            
            $data['errors'] = $this->validator->getErrors();
        
            return $this->prikaz("serviceChange",$data);
        }
        else{

            $model-> UpdateServiceById($idUsluga,$name,$tip_id,$cena,$trajanje);
            return redirect()->to(site_url('salon/offer_page'));
            
        }

    }
    /* Prikaz stranice za kreiranje i dodavanje nove usluge salona --- Petar */
    function addServicePage(){
        $db = db_connect();
        $model = new SalonModel($db);
        $data['tipovi'] = $model->getAllTypes();
        
        return $this->prikaz("newService",$data);

    }
    /* Dodavanje nove usluge salona --- Petar */
    function addService(){
        $db = db_connect();
        $model = new SalonModel($db);
        $naziv =  $this->request->getVar('naziv');
        $cena= $this->request->getVar('cena');
        $trajanje =  $this->request->getVar('trajanje');
        $tip = $this->request->getVar('tip');
        $idTip = $model->getTypeIdbyName($tip)[0]->idTip;

        $idSalon = session()->get('user')->idKorisnik;
        $rules = [
            
            'naziv' => 'required|max_length[40]',
            
            'cena' => 'required|numeric|max_length[8]|greater_than[0]',
            'trajanje'=>'required|numeric|max_length[3]|greater_than[0]'
        ];
    
        $errors = [
            
            'naziv' => [
                'required' =>'Ime je obavezno polje',
                
                'max_length' => 'Ime usluge može imati maksimalno 40 karaktera'
            ],
            'trajanje' => [
                'required' =>'Trajanje je obavezno polje',
                'numeric' => 'Trajanje termina mora sadrzati samo cifre',
                'max_length' => 'Trajanje može imati maksimalno 3 cifre(minuti)',
                'greater_than' => 'Trajanje mora biti veće od 0'
                
            ],
            'cena' => [
                'required' =>'Cena je obavezno polje',
                'numeric' => 'Cena mora sadrzati samo cifre',
                'greater_than' => 'Cena mora biti pozitivan broj',
                'max_length' => 'Cena mora sadrzati maksimalno 8 cifara'
            ]
            
        ];
        if(!$this->validate($rules, $errors)){
            $db = db_connect();
            $model = new SalonModel($db);
            $data['tipovi'] = $model->getAllTypes();
            
            
            $data['errors'] = $this->validator->getErrors();
        
            return $this->prikaz("newService", $data);
        }
        else{

            $model->addService($naziv,$idSalon,$idTip,$cena,$trajanje);
            return redirect()->to(site_url('/salon/offer_page'));
            
        }

        

    }
     /* Brisanje usluge salona --- Petar */
    function deleteService($idU){
        $db = db_connect();
        $model = new SalonModel($db);
        $model->deleteService($idU);
        return redirect()->to(site_url('/salon/offer_page'));

    }
     /* Prikaz stranice koje potvrdjuje da je mail poslat --- Petar */
    public function email_conf_page_salon(){
        $db = db_connect();
        $model = new SalonModel($db);
        $salon=session()->get('user');
        $data['supp']=$model->getUserById($salon->idKorisnik)[0];
        
        return $this->prikaz('confirmedMailSalon',$data);
    }
    

    //galerija Mihajlo

    function gallery(){
        $db = db_connect();
        $model = new SalonModel($db);
        $salon=session()->get('user');
        $data['salon']=$model->getSalon($salon)[0];
        $data['slike']=$model->getGallery($salon->idKorisnik);
        $data['errors']=session()->get('errors');
        return $this->prikaz("salon_gallery", $data);
    }

    function addImage(){
        $db = db_connect();
        $model = new SalonModel($db);
        $salon=$model->getSalon(session()->get('user'))[0];

        $rules = ['image' => 'uploaded[image]|is_image[image]|max_size[image,600]'];
        $errors = ['image' => [
            'is_image' => 'Morate odabrati sliku pre dodavanja',
            'max_size' => 'Maksimalna dozvoljena velicina 600 KB'
        ]
        ];
        
        $file = $this->request->getFile('image');
        if ($file->isValid() && ! $file->hasMoved() && $this->validate($rules, $errors)) {
            $newName = $file->getRandomName();
            $file->move('assets/images/gallery/', $newName);

            $data=[
                'putanja' => "assets/images/gallery/$newName",
                'idSalon' => $salon->idSalon
            ];
            
            $errors = $this->validator->getErrors();

            session()->set('errors', $errors);
            $model->addGallery($data);
        }

        
        return $this->gallery();
    }

    function deleteImage($id){
        $db = db_connect();
        $model = new SalonModel($db);
        //$salon=$model->getSalon(session()->get('user'))[0];

        $name = $model->getImage($id)[0]->putanja;

        if(file_exists($name)){
            unlink($name);
            if(!($model->deleteImage($id))){
                alert("Doslo je do greske pri brisanju");
            }
        }
        else{
            echo '<script>alert("NE MOZE")</script>';
        }
        
        return $this->gallery();
        
    }
    public function send_mail_salon(){
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
                
            ]];
        
        if(!$this->validate($rules, $errors)){
            $errs = $this->validator->getErrors();
            $db = db_connect();
            $model = new UserModel($db);
            $user = session()->get('user');
            
            $data['errors'] = $errs;
        
            return $this->prikaz("salon_support", $data);
            
            
           
        }
        else{
            if($email->send()){
                return redirect()->to(site_url('Salon/email_conf_page_salon'));   
            }
            else{
                $data = $email->printDebugger(['headers']);
                return view('proba',['errors2'=>$data]);
            }

        }
    }


    
}
