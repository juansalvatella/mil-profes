<?php

class PopulateController extends BaseController
{
    //Cantidades (students y teachers han de ser igual o menores a users)
    const NUSERS = 10;
    const NTEACHERS = 5;
    const NSTUDENTS = self::NUSERS;
    const NSCHOOLS = 10;
    const NLESSONS = 10; //teacher or school lessons
    const NRATINGS = 10;

    public function unpopulate()
    {
        //$this->deleteAllRowsInAllTables(); //BEWARE!!! For testing purposes ONLY!!!
        echo("<br>The End");
    }

    public function populate()
    { //Si NO se tiene una base de datos recién creada, descomentar el primer método para vaciar todas las tablas
//        $this->deleteAllRowsInAllTables(); //BEWARE!!! For testing purposes ONLY!!!

//        $this->populateUsers(); //descomentar la clase Users para test (ver modelo User.php), CONFIDE impide guardar users de forma programática
//        $this->makeAllUsersStudents(); //todos los users son estudiantes por defecto
//        $this->makeSomeUsersTeachers(); //algunos serán, además, profesores
//
//        $this->populateSchools(); //escuelas
//        $this->populateSubjects(); //materias
//
//        $this->populateTeacherLessons(); //lecciones/clases con 1 profesor (docente) y 1 materia relacionados
//        $this->populateSchoolLessons(); //lecciones/clases con 1 academia (docente) y 1 materia relacionados
//        $this->populateRatings(); //ratings, con 1 clase (puntuada) y 1 estudiante (puntuador) relacionados

//        $this->populateRoles();
//        $this->populatePermissions();
//        $this->relatePermissionsWithRoles();
        
//        $this->createUserAdmin(); //descomentar la clase Users para test (ver modelo User.php), CONFIDE impide guardar users de forma programática
        $this->relateUsersWithRoles();

        echo("<br>The End");

    } //This method only works on fresh created tables (if all ids starts counting from 1)

    private function deleteAllRowsInAllTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ratings')->truncate();
        DB::table('school_lessons')->truncate();
        DB::table('teacher_lessons')->truncate();
        DB::table('subjects')->truncate();
        DB::table('students')->truncate();
        DB::table('teachers')->truncate();
        DB::table('users')->truncate();
        DB::table('schools')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('assigned_roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo("Se han vaciado todas las tablas<br>");
    }

    private function populateUsers()
    {
        for ($i=0;$i<self::NUSERS;++$i)
        {
            $str = (string) $i;
            $user = new User();
            $user->name = 'Nombre'.$str;
            $user->lastname = 'Varios Apellidos'.$str;
            $user->email = 'estudiante'.$str.'@email.com';
            $user->phone = '666 55 44 '.$str;
            if (!isset($i2)) { $i2 = 1; }
            $i2 += 20;
            $str2 = (string) $i2;
            $user->address = 'Passeig de Gràcia '.$str2.', Barcelona';
            $user->avatar = 'default_avatar.jpg';
            $user->availability = 'Not implemented yet';
            $user->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, a';
            $add_encoded = Geocoding::geocode($user->address);
            $user->lat = $add_encoded[0]; //latitud
            $user->lon = $add_encoded[1]; //longitud
            $user->username = 'perdofime'.$i;
            $user->password = '$2y$10$Ql8qVV7kvrBVYII3jdaHce6lECWNAAc5xjxH5WJ0D7FEw5TFO0Dwq';
            $user->confirmation_code = '0f51f2ad89589ac5c62f7264a09fc814';
            $user->remember_token = null;
            $user->confirmed = true;
            
            if(!($user->save()))
                dd('No se ha podido poblar la tabla de usuarios. Error al introducir usuario '.($i+1).' de '.self::NUSERS);
        }
        echo("Se ha poblado la tabla usuarios con 10 usuarios<br>");
    }

    private function makeAllUsersStudents()
    {
        for($i=1;$i<(self::NSTUDENTS+1);++$i)
        {
            $user = User::findOrFail($i);
            $student = new Student();
            $student->user()->associate($user);
            $student->save();
        }
        echo("Todos los usarios son estudiantes<br>");
    }

    private function makeSomeUsersTeachers()
    {
        for($i=1;$i<(self::NTEACHERS+1);++$i)
        {
            $user = User::findOrFail($i);
            $teacher = new Teacher();
            $teacher->user()->associate($user);
            $teacher->save();
        }
        echo("Los ".self::NTEACHERS." primeros usarios son profesores<br>");
    }

    private function populateSchools()
    {
        for ($i=0;$i<self::NSCHOOLS;++$i)
        {
            $str = (string) $i;
            $school = new School();
            $school->name = 'Academia'.$str;
            $school->cif = '9876543'.$str;
            $school->phone = '999 88 55 '.$str;
            $school->phone2 = '999 88 66 '.$str;
            $school->email = 'academia'.$str.'@email.com';
                if (!isset($i2)) { $i2 = 1; }
                $i2 += 20;
                $str2 = (string) $i2;
            $school->address = 'Avenida Meridiana '.$str2.', Barcelona';
            $add_encoded = Geocoding::geocode($school->address);
            $school->lat = $add_encoded[0]; //latitud
            $school->lon = $add_encoded[1]; //longitud
            $school->logo = 'default_logo.jpg';
            $school->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
            if(!($school->save()))
                dd('No se ha podido poblar la tabla de academias');
        }
        echo("Se ha poblado la tabla de academias<br>");
    }

    private function populateSubjects()
    {
        $esenciales = array('escolar','cfp','universitario','artes','música','idiomas','deportes');
        for ($i=0;$i<sizeof($esenciales);++$i)
        {
            $subject = new Subject();
            $subject->name = $esenciales[$i];
            if(!($subject->save()))
                dd('No se ha podido poblar la tabla de materias');
        }
        echo("Se ha poblado la tabla de materias básicas<br>");
    }

    private function populateTeacherLessons()
    { //Each lesson relates 1 teacher and 1 subject with the lesson itself
        for ($i=0;$i<self::NLESSONS;++$i)
        {
            $lesson = new TeacherLesson();
            $rprice = (float) mt_rand(50,199)/10;
            $lesson->price = $rprice;
            $lesson->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
                $rid1 = (integer) mt_rand(1,self::NTEACHERS);
            $teacher = Teacher::findOrFail($rid1);
                $rid2 = (integer) mt_rand(1,7); //Pq hay 7 asignaturas básicas
            $subject = Subject::findOrFail($rid2);
            $lesson->teacher()->associate($teacher);
            $lesson->subject()->associate($subject);
            if(!($lesson->save()))
                dd('No se ha podido poblar la tabla de lecciones');
        }
        echo("Se ha poblado la tabla de clases con ".self::NLESSONS." lecciones (impartidas por profesores)<br>");
    }

    private function populateSchoolLessons()
    { //Each lesson relates 1 school and 1 subject with the lesson itself
        for ($i=0;$i<self::NLESSONS;++$i)
        {
            $lesson = new SchoolLesson();
            $rprice = (float) mt_rand(50,199)/10;
            $lesson->price = $rprice;
            $lesson->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
                $rid1 = (integer) mt_rand(1,self::NSCHOOLS);
            $school = School::findOrFail($rid1);
                $rid2 = (integer) mt_rand(1,7); //Pq hay 7 asignaturas básicas
            $subject = Subject::findOrFail($rid2);
            $lesson->school()->associate($school);
            $lesson->subject()->associate($subject);
            if(!($lesson->save()))
                dd('No se ha podido poblar la tabla de lecciones');
        }
        echo("Se ha poblado la tabla de clases con ".self::NLESSONS." lecciones (impartidas por academias)<br>");
    }

    private function populateRatings()
    { //Each rating relates 1 student (rater) and 1 teacher-lesson (rated) with the rating itself
        for($i=0;$i<self::NRATINGS;++$i)
        {
            $rating = new Rating();
                $nota = (float) mt_rand(0,50)/10; //Entre 0 y 5
            $rating->value = $nota;
            $rating->comment = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
                $rid1 = (integer) mt_rand(1,self::NSTUDENTS);
            $student = Student::findOrFail($rid1);
                $rid2 = (integer) mt_rand(1,self::NLESSONS);
            $lesson = TeacherLesson::findOrFail($rid2);
            $rating->student()->associate($student);
            $rating->lesson()->associate($lesson);
            if(!($rating->save()))
                dd('No se ha podido poblar la tabla de ratings<br>');
        }
        echo("Se ha poblado la tabla de ratings<br>");
    }

    private function populateRoles()
    {
        $admin = new Role;
        $admin->name = 'admin';
        $admin->save();

        $teacher = new Role;
        $teacher->name = 'teacher';
        $teacher->save();

        $student = new Role;
        $student->name = 'student';
        $student->save();

        echo("Se ha poblado la tabla de roles<br>");
    }

    private function populatePermissions()
    {
        $manageLessons = new Permission;
        $manageLessons->name = 'manage_lessons';
        $manageLessons->display_name = 'Administrar clases';
        $manageLessons->save();

        $manageSchools = new Permission;
        $manageSchools->name = 'manage_schools';
        $manageSchools->display_name = 'Administrar academias';
        $manageSchools->save();

        $manageUsers = new Permission;
        $manageUsers->name = 'manage_users';
        $manageUsers->display_name = 'Administrar usuarios';
        $manageUsers->save();

        echo("Se ha poblado la tabla de permisos<br>");
    }

    private function relatePermissionsWithRoles()
    {
        $managelessons = Permission::where('name','manage_lessons')->first();
        $manageusers = Permission::where('name','manage_users')->first();
        $manageschools = Permission::where('name','manage_schools')->first();
        $student_role = Role::where('name','student')->first();
        $teacher_role = Role::where('name','teacher')->first();
        $admin_role = Role::where('name','admin')->first();

        $student_role->perms()->sync(array($manageusers->id));
        $teacher_role->perms()->sync(array($managelessons->id));
        $admin_role->perms()->sync(array($managelessons->id,$manageusers->id,$manageschools->id));

        echo("Se ha poblado la tabla que relaciona permisos y roles básicos<br>");
    }

    private function createUserAdmin()
    {
        $admin = new User();
        $admin->username = 'admin';
        $admin->name = 'Administrador';
        $admin->lastname = 'Network';
        $admin->email = 'mitxel@network30.com';
        $admin->phone = '622 70 63 10';
        $admin->avatar = 'default_avatar.jpg';
        $admin->availability = 'Not implemented yet';
        $admin->description = 'Mil Profes Admin';
        $admin->address = 'Plaça Catalunya 1, Barcelona';
        $add_encoded = Geocoding::geocode($admin->address);
        $admin->lat = $add_encoded[0]; //latitud
        $admin->lon = $add_encoded[1]; //longitud
        $admin->password = '$2y$10$Ql8qVV7kvrBVYII3jdaHce6lECWNAAc5xjxH5WJ0D7FEw5TFO0Dwq';
        $admin->confirmation_code = '0f51f2ad89589ac5c62f7264a09fc814';
        $admin->remember_token = null;
        $admin->confirmed = true;

        if(!($admin->save()))
            dd('No se ha podido crear al usuario Administrador');

        echo("Se ha creado al usuario Administrador<br>");
    }
    
    private function relateUsersWithRoles()
    {
        $student_role = Role::where('name','student')->first();
        $teacher_role = Role::where('name','teacher')->first();
        $admin_role = Role::where('name','admin')->first();

        $admin_user = User::where('email','mitxel@network30.com')->first();
        $admin_user->attachRole($admin_role);
        $admin_user->attachRole($student_role);
        $admin_user->attachRole($teacher_role);

        for ($i=1;$i<(self::NUSERS+1);++$i)
        {
            if($i<(self::NTEACHERS+1)) //asignar rol de estudiante y profesor
            {
                $user_teacher = User::findOrFail($i);
                $user_teacher->attachRole($teacher_role);
                $user_teacher->attachRole($student_role);
            }
            else //asignar rol de estudiante
            {
                $user_student = User::findOrFail($i);
                $user_student->attachRole($student_role);
            }
        }
        echo("Se han asignado roles Admin, Student y Teacher a diversos usuarios<br>");
    }

}