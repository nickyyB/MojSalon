<?php

namespace App\Models;

/*
 * Autor: Danica Jakovljevic 0305/2019
 * Autor: Nikola Brkovic 0647/2014
 * Autor: Petar Jovovic 0352/2019
 * Recenzija: Micke
 */


use CodeIgniter\Database\ConnectionInterface;

class UserModel
{
    protected $db;


    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

    /* Spajanje osnovnih i korisnickih informacija usera --- Petar */

    function getUserData($username)
    {
        $builder = $this->db->table('korisnik');

        $builder->where('kIme', $username);
        $builder->join('osnovni', 'osnovni.idOsnovni = korisnik.idKorisnik');
        return $builder->get()->getRow();
    }
    /* Menjanje profila korisnika --- Petar */

    function changeUserData($id,  $phone, $name, $surname, $munc)
    {

        $builder = $this->db->table('korisnik');
        $data = [
            
            'telefon' => $phone
        ];
        $builder->set($data);



        $builder->where('idKorisnik', $id);

        $query1 = $builder->getCompiledUpdate();
        $data2 = [
            'ime' => $name,
            'prezime' => $surname,
            'opstina' => $munc
        ];
        $builder->resetQuery();

        $builder = $this->db->table('osnovni');
        $builder->set($data2);

        $builder->where('idOsnovni', $id);

        $query2 = $builder->getCompiledUpdate();
        $this->db->transStart();
        $this->db->query($query1);
        $this->db->query($query2);
        $this->db->transComplete();


        if ($this->db->transStatus() === false) {
            return false;
        } else return true;
    }


    /**Custom paginacija termina --- Danica */
    public function paginate($userId, ?int $perPage = null, string $group = 'default', ?int $page = null, int $segment = 0)
    {
        $pager = \Config\Services::pager();

        if ($segment) {
            $pager->setSegment($segment);
        }

        $page = $page >= 1 ? $page : $pager->getCurrentPage($group);
        // Store it in the Pager library, so it can be paginated in the views.
        $this->pager = $pager->store($group, $page, $perPage, $this->getAppointmentCountForUser($userId), $segment);
        $perPage     = $this->pager->getPerPage($group);
        $offset      = ($pager->getCurrentPage($group) - 1) * $perPage;

        return $this->getAppointmentsForUser($userId, $perPage, $offset);
    }


    /* Dohvatanje korisnika iz baze za login --- Nikola */
    function getUser($user)
    {
        $builder = $this->db->table('korisnik');
        $builder->where('email', $user)->orWhere('kIme', $user);
        $builder->where('stanje', 1);
        return $builder->get()->getRow();
    }

    function getState($user)
    {
        $builder = $this->db->table('osnovni');
        $builder->select('`opstina`');
        $builder->where('idOsnovni', $user->idKorisnik);
        return $builder->get()->getRow();
    }

    /* Dohvatanje tipa korisnika iz baze za login kako bi se redirektovalo na pravi kontroler --- Nikola */
    function getTypeOfUser($user)
    {
        $builder = $this->db->table('osnovni');
        $builder->where('idOsnovni', $user->idKorisnik);
        $res = $builder->get()->getRow();
        if ($res == null) {
            $builder = $this->db->table('salon');
            $builder->where('idSalon', $user->idKorisnik);
            $res = $builder->get()->getRow();
            if ($res == null) {
                return 'Admin';
            } else {
                return 'salon';
            }
        } else {
            return 'User';
        }
    }

    /* Dodavanje generalnog korisnika u bazu --- Nikola */
    function addUser($user)
    {
        $builder = $this->db->table('korisnik');
        $builder->insert($user);
        return $this->db->insertID();
    }

    /* Dodavanje obicnog korisnika u bazu --- Nikola */
    function addBasicUser($general, $basic)
    {
        $this->db->transStart();
        $basic['idOsnovni'] = $this->addUser($general);
        $builder = $this->db->table('osnovni');
        $builder->insert($basic);
        $this->db->transComplete();
    }

    /* Dodavanje admina u bazu --- Nikola */
    function addAdminUser($general, $admin)
    {
        $this->db->transStart();
        $admin['idAdmin'] = $this->addUser($general);
        $builder = $this->db->table('admin');
        $builder->insert($admin);
        $this->db->transComplete();
    }

    /* Dodavanje salona u bazu --- Nikola */
    function addSalonUser($general, $salon, $workingHours){

        $this->db->transStart();
        $salon['idSalon'] = $this->addUser($general);
        $builder = $this->db->table('salon');
        $builder->insert($salon);
        /*Dodavanje radnog vremena*/
        $this->addWorkingHours($workingHours, $salon['idSalon']);
        $this->db->transComplete();
    }
    
    function addWorkingHours($days, $id){
        $data['idSalon']=$id;
        if($days['mon']=='on'){
            $from = $days['monFrom'];
            $to = $days['monTo'];
            $data['pon'] = $from . "-" . $to;
        }
        if($days['tue']=='on'){
            $from = $days['tueFrom'];
            $to = $days['tueTo'];
            $data['uto'] = $from . "-" . $to;
        }
        if($days['wed']=='on'){
            $from = $days['tueFrom'];
            $to = $days['tueTo'];
            $data['sre'] = $from . "-" . $to;
        }
        if($days['thu']=='on'){
            $from = $days['tueFrom'];
            $to = $days['tueTo'];
            $data['cet'] = $from . "-" . $to;
        }
        if($days['fri']=='on'){
            $from = $days['tueFrom'];
            $to = $days['tueTo'];
            $data['pet'] = $from . "-" . $to;
        }
        if($days['sat']=='on'){
            $from = $days['tueFrom'];
            $to = $days['tueTo'];
            $data['sub'] = $from . "-" . $to;
        }   
        if($days['sun']=='on'){
            $from = $days['tueFrom'];
            $to = $days['tueTo'];
            $data['ned'] = $from . "-" . $to;
        }   
        $builder=$this->db->table('radnoVreme');
        $builder->insert($data);
    }


    /*
    *Dohvatanje svih termina za jednog korisnika, id korisnika je parametar
    *Danica
    */
    function getAppointmentsForUser($userId, $limit, $offset)
    {
        $builder = $this->db->table('termin');
        $builder->select('`idTermin`, `termin`.`datum`, `termin`.`stanje`, `termin`.`cena`, `termin`.`naziv` as nazivUsluge, `termin`.`nazivSalona` as nazivSalona');
        $builder->where('idOsnovni', $userId);
        $builder->orderBy('datum', 'DESC');
        $builder->limit($limit, $offset);
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Dohvatanje broja termina za korisnika (za paginaciju)
     * Danica
     */
    function getAppointmentCountForUser($userId)
    {
        $builder = $this->db->table('termin');
        $builder->where('idOsnovni', $userId);
        return  $builder->countAll();
    }

    /**
     * Dohvatanje broja uspesno zavrsenih termina za korisnika (za status)
     * Danica
     */
    function getAppointmentCountForUserStatus($userId)
    {
        $builder = $this->db->table('termin');
        $builder->where('idOsnovni', $userId);
        $builder->where('stanje !=', 3);
        $builder->where('stanje !=', 1);
        $builder->where('datum <=', date('Y-m-d H:i:s'));
        return  $builder->countAllResults();
    }

    /*
    *Dodavanje komentara za termin i promena njegovog statusa
    *Danica
    */
    function insertReview($appointmentId, $rating, $comment)
    {
        $appointment = $this->getAppointmentById($appointmentId)[0];
        $currentDate = strtotime(date('Y-m-d H:i:s'));
        $appointmentDate = strtotime($appointment->datum);
        $days = ($currentDate - $appointmentDate) / 86400;
        if (
            session()->get('user')->idKorisnik != $appointment->idOsnovni
            || $appointment->stanje == 4
            || !($days > 0 && $days < 7 && $appointment->stanje == 2)
        ) {
            return false;
        }

        $builder = $this->db->table('termin');
        $builder->select('`termin`.`idOsnovni` as idOsnovni, `termin`.`stanje`, `usluga`.`idSalon` as idSalon');
        $builder->join('usluga', 'usluga.idUsluga = termin.idUsluga');
        $builder->where('idTermin', $appointmentId);
        $row = $builder->get()->getResult();
        if ($row[0]->stanje != 2) {
            return false;
        }
        $data = [
            'tekst' => $comment,
            'ocena' => $rating,
            'idOsnovni' => $row[0]->idOsnovni,
            'idSalon' => $row[0]->idSalon
        ];
        $builder->resetQuery();
        $builder->set('stanje', 4);
        $builder->where('idTermin', $appointmentId);
        $query1 = $builder->getCompiledUpdate();
        //$query1 = $builder->get();
        $builder->resetQuery();
        $builder = $this->db->table('komentar');
        $builder->set($data);
        //$builder->insert();
        $query2 = $builder->getCompiledInsert();

        $this->db->transStart();
        $this->db->query($query1);
        $this->db->query($query2);
        $this->db->transComplete();


        if ($this->db->transStatus() === false) {
            return false;
        } else return true;
    }

    /**Dohvatanje termina na osnovu id --- Danica */
    function getAppointmentById($id)
    {
        $builder = $this->db->table('termin');
        return $builder->where('idTermin', $id)->get()->getResult();
    }

    /**
     * Otkazivanje termina
     * Danica
     */
    function cancelAppointment($appointmentId)
    {
        $appointment = $this->getAppointmentById($appointmentId)[0];
        if (session()->get('user')->idKorisnik != $appointment->idOsnovni || $appointment->stanje == 4) {
            return false;
        }

        $this->db->transStart();
        $builder = $this->db->table('termin');
        $builder->set('stanje', 3);
        $builder->where('idTermin', $appointmentId);
        $builder->update();
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        } else return true;
    }

    /**Dodavanje termina --- Danica*/
    function insertAppointment($userId, $serviceId, $datetime, $discount)
    {
        $appointment = [
            "idOsnovni" => $userId,
            "datum" => $datetime,
            "stanje" => 1,
            "idUsluga" => $serviceId
        ];
        $builder = $this->db->table('usluga');
        $builder->select('cena, `usluga`.`naziv` as naziv, `salon`.`naziv` as nazivSalona');
        $builder->join('salon', "salon.idSalon = usluga.idSalon");
        $builder->where('idUsluga', $serviceId);
        $row = $builder->get()->getRow();
        if ($discount != null)
            $price = number_format($row->cena * (1 - $discount / 100), 2, '.', '');
        else
            $price = $row->cena;
        $appointment['cena'] = $price;
        $appointment['naziv'] = $row->naziv;
        $appointment['nazivSalona'] = $row->nazivSalona;
        $builder->resetQuery();
        $this->db->transStart();
        $builder = $this->db->table('termin');
        $builder->insert($appointment);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        } else return true;
    }

    /**
     * Dohvatanje svih aktivnih korisnika
     */
    function getActiveUsers()
    {
        $builder = $this->db->table('osnovni');
        $builder->select('`ime`, `prezime`, `idKorisnik`, `idOsnovni`, `korisnik`.`kIme` as kIme, `opstina`, `datumR`');
        $builder->join('korisnik', 'osnovni.idOsnovni = korisnik.idKorisnik AND korisnik.stanje=1');
        $users = $builder->get()->getResult();
        return $users;
    }

    /**
     * Micke
     * Dohvatanje blokiranih korisnika
     */

    function getBlockedUsers()
    {
        $builder = $this->db->table('osnovni');
        $builder->select('`ime`, `prezime`, `idKorisnik`, `idOsnovni`, `korisnik`.`kIme` as kIme, `opstina`, `datumR`');
        $builder->join('korisnik', 'osnovni.idOsnovni = korisnik.idKorisnik AND korisnik.stanje=0');
        $users = $builder->get()->getResult();
        return $users;
    }
    function getUserById($id)
    {
        $builder = $this->db->table('korisnik');
        return $builder->where('idKorisnik', $id)->get()->getResult();
    }




    /**
     * Mihajlo
     * Dohvatanje aktivnih korisnika po user/mail
     */

    function searchUsers($query)
    {
        $builder = $this->db->table('korisnik');
        $builder->join('osnovni', 'osnovni.idOsnovni = korisnik.idKorisnik AND korisnik.stanje=1');
        $builder->like('korisnik.email', $query)->orlike('korisnik.kIme', $query);
        $users = $builder->get()->getResult();
        return $users;
    }

    /**
     * Mihajlo
     * Dohvatanje blokiranih korisnika po user/mail
     */

    function searchBlockedUsers($query)
    {
        $builder = $this->db->table('korisnik');
        $builder->join('osnovni', 'osnovni.idOsnovni = korisnik.idKorisnik AND korisnik.stanje=0');
        $builder->like('korisnik.email', $query)->orlike('korisnik.kIme', $query);
        $users = $builder->get()->getResult();
        return $users;
    }

    /**
     * Micke
     * Brisanje/blokiranje/odblokiranje korisnika po username
     */

    function deleteUser($query)
    {
        $this->db->transStart();
        $builder = $this->db->table('korisnik');
        $builder->delete(['kIme' => $query]);
        $this->db->transComplete();
    }

    function blockUser($query)
    {
        $this->db->transStart();
        $builder = $this->db->table('korisnik');
        $builder->where('kIme', $query);
        $builder->set('stanje', 0);
        $builder->update();
        $this->db->transComplete();
    }

    function unblockUser($query)
    {
        $this->db->transStart();
        $builder = $this->db->table('korisnik');
        $builder->where('kIme', $query);
        $builder->set('stanje', 1);
        $builder->update();
        $this->db->transComplete();
    }


    /* Dohvatanje salona sa stanjem NULL --- Nikola*/
    function salonNull()
    {
        $builder = $this->db->table('korisnik');
        $builder->join('salon', 'salon.idSalon =  korisnik.idKorisnik and korisnik.stanje IS NULL');
        return $builder->get()->getResult();
    }

    function salonSetStatus($username, $status)
    {
        $builder = $this->db->table('korisnik');
        $builder->set('stanje', $status)
            ->where('kIme', $username);
        $builder->update();
    }
}
