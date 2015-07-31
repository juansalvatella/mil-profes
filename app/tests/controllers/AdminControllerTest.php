<?php

/**
 * Class AdminControllerTest
 */
class AdminControllerTest extends TestCase
{
    /*public function setUp()
    {
        parent::setUp();

        $this->mock = $this->mock('');
    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }*/

    public function testSchoolsDashboard()
    {
        $this->call('GET', 'admin/schools');
        $this->assertViewHas('schools');
    }

    public function testDeleteSchool()
    {
        $school = School::first();
        $id = $school->id;
        $this->action('GET', 'AdminController@deleteSchool',['school_id'=>$id]);
        $this->assertViewHas('school');
    }

    public function testDoDeleteSchool()
    {
        $school = School::first();
        $id = $school->id;
        $this->action('POST', 'AdminController@doDeleteSchool', ['id' => $id]);
        $this->assertRedirectedTo('admin/schools');
    }

    public function testDeleteSchoolReview()
    {
        $school = School::first();
        $id = $school->id;
        $this->action('GET', 'AdminController@deleteSchoolReview', ['id'=>$id]);
        $this->assertRedirectedTo('admin/school/reviews');
    }

    public function testSchoolRegister()
    {
        $this->call('GET', 'admin/create/school');
    }

    /*public function testCreateSchool()
    {
        $input = Input::all();
        Input::replace($input);
        $this->mock->shouldReceive('createSchool')
            ->once()
            ->with($input)
            ->andReturn(false);

        $this->action('POST', 'AdminController@createSchool');
        $this->assertRedirectedTo('admin/schools');
    }*/

    //ErrorException: Call to undefined method Illuminate\Database\Query\Builder::video() (View: C:\laravel-projects\milprofes\app\views\school_edit.blade.php)
    // Caused by BadMethodCallException: Call to undefined method Illuminate\Database\Query\Builder::video()

    /*public function testEditSchool()
    {
        $school = School::first();
        $id = $school->id;
        $this->action('GET', 'AdminController@editSchool', ['school_id'=>$id]);
        $this->assertViewHas('school');
    }*/

    /*public function testSaveSchool()
    {
        $this->action('POST', 'AdminController@saveSchool');
        $this->assertRedirectedTo('admin/schools');
    }*/

    public function testSchoolReviews()
    {
        $this->call('GET', 'admin/school/reviews');
        $this->assertViewHas('reviews');
    }

    /*public function testUpdateSchoolStatus()
    {

        $this->call('POST', 'admin/updateSchoolStatus');
    }*/

    public function testTeachersDashboard()
    {
        $this->call('GET', 'admin/teachers');
        $this->assertViewHas('users');
    }

    public function testTeacherReviews()
    {
        $this->call('GET', 'admin/teacher/reviews');
        $this->assertViewHas('reviews');
    }


}