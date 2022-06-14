<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Config\Factories;
use Config\Services;
use CodeIgniter\HTTP\URI;

class UserControllerTest extends CIUnitTestCase
{

    /***Napomena: 
     * za testiranje je neohodno zameniti kreiranje modela (u klasi User.php) dohvatanjem modela iz fabrike 
     * $model=Factories::models('App\Models\UserModel');
     * $salonModel = Factories::models('App\Models\UserModel');
     */

    use ControllerTester;

    public function setUp(): void
    {
        parent::setUp();
        $user = (object)[
            'idKorisnik' => 4,
            'email' => 'user4@gmail.com',
            'kIme' => 'user4',
            'lozinka' => 'sifra123',
            'telefon' => '064222336',
            'stanje' => 1
        ];

        $map = [
            ['user', $user],
            ['controller', 'User']
        ];

        $sessionMock = $this->getMockBuilder('CodeIgniter\Session')
            ->setMethods(['get', 'set'])
            ->getMock();
        $sessionMock->method('get')->will($this->returnValueMap($map));
        $sessionMock->method('set');
        Services::injectMock('session', $sessionMock);
    }

    public function test_appointments()
    {
        $appointments = [
            (object)[
                'idTermin' => 1,
                'idOsnovni' => 4,
                'datum' => '2022-05-31 19:30:00',
                'stanje' => 2,
                'idUsluga' => 10,
                'cena' => 1200.00,
                'nazivUsluge' => 'Manikir + lakiranje noktiju',
                'nazivSalona' => 'Gaga G&T'
            ]
        ];

        $mockUserModel = $this->createMock(\App\Models\UserModel::class);
        $mockUserModel->pager = \Config\Services::pager();
        $mockUserModel->method('paginate')->willReturn($appointments);
        Factories::injectMock('models', '\App\Models\UserModel', $mockUserModel);

        $results = $this->controller('\App\Controllers\User')->execute("appointments");
        $this->assertTrue(($results->see('Manikir + lakiranje noktiju', 'h4')));
    }

    public function test_status()
    {
        $count = 12;

        $mockUserModel = $this->createMock(\App\Models\UserModel::class);
        $mockUserModel->method('getAppointmentCountForUserStatus')->willReturn($count);
        Factories::injectMock('models', '\App\Models\UserModel', $mockUserModel);

        $results = $this->controller('\App\Controllers\User')->execute('status');
        $this->assertTrue($results->see('Status - MojSalon', 'title'));
        $this->assertTrue($results->see('Bronzanog', 'em'));
    }

    public function test_review_failed()
    {
        $appointment = [
            (object)[
                'idTermin' => 1,
                'idOsnovni' => 4,
                'datum' => '2022-05-31 19:30:00',
                'stanje' => 2,
                'idUsluga' => 10,
                'cena' => 1200.00,
                'nazivUsluge' => 'Manikir + lakiranje noktiju',
                'nazivSalona' => 'Gaga G&T'
            ]
        ];

        $request = new \CodeIgniter\HTTP\IncomingRequest(new \Config\App(), new URI(site_url('User/review/23')), '', new \CodeIgniter\HTTP\UserAgent());
        $request->setMethod('post');
        $request->setGlobal('request', [
            'comment' => '',
        ]);

        $results = $this->withRequest($request)
            ->controller('\App\Controllers\User')
            ->execute("review", 1);

        $this->assertTrue($results->see('Morate uneti ocenu', 'p'));
    }

    public function test_review()
    {
        $appointment = [
            (object)[
                'idTermin' => 1,
                'idOsnovni' => 4,
                'datum' => '2022-05-31 19:30:00',
                'stanje' => 2,
                'idUsluga' => 10,
                'cena' => 1000.00,
                'nazivUsluge' => 'Manikir + lakiranje noktiju',
                'nazivSalona' => 'Gaga G&T'
            ]
        ];

        $service = (object)[
            'idUsluga' => 10,
            'cena' => 1000.00,
            'naziv' => 'Manikir + lakiranje noktiju',
            'idSalon' => 16,
            'trajanje' => 40,
            'idTip' => 5

        ];

        $mockUserModel = $this->createMock(\App\Models\UserModel::class);
        $mockUserModel->method('insertReview')->willReturn(true);
        $mockUserModel->method('getAppointmentById')->willReturn($appointment);
        Factories::injectMock('models', '\App\Models\UserModel', $mockUserModel);

        $mockSalonModel = $this->createMock(\App\Models\SalonModel::class);
        $mockSalonModel->method('getServiceById')->willReturn($service);
        Factories::injectMock('models', '\App\Models\SalonModel', $mockSalonModel);

        $request = new \CodeIgniter\HTTP\IncomingRequest(new \Config\App(), new URI(site_url('User/review/23')), '', new \CodeIgniter\HTTP\UserAgent());
        $request->setMethod('post');
        $request->setGlobal('request', [
            'comment' => '',
            'rating' => 5
        ]);

        $results = $this->withRequest($request)
            ->controller('\App\Controllers\User')
            ->execute("review", 1);

        // $this->assertTrue($results->see('MojSalon - Gaga G&T', 'title'));
    }
}
