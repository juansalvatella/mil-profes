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

    public function populate()
    { //Si NO se tiene una base de datos recién creada, descomentar el primer método para eliminar todos las rows de las tablas
        //$this->deleteAllRowsInAllTables(); //BEWARE!!! For testing purposes ONLY!!!

        $this->populateUsers(); //users
        $this->makeAllUsersStudents(); //todos los users son estudiantes por defecto
        $this->makeSomeUsersTeachers(); //algunos serán, además, profesores

        $this->populateSchools(); //escuelas
        $this->populateSubjects(); //materias

        $this->populateTeacherLessons(); //lecciones/clases con 1 profesor (docente) y 1 materia relacionados
        $this->populateSchoolLessons(); //lecciones/clases con 1 academia (docente) y 1 materia relacionados
        $this->populateRatings(); //ratings, con 1 clase (puntuada) y 1 estudiante (puntuador) relacionados

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
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
                $i2 += 5;
                $str2 = (string) $i2;
            $user->address = 'Passeig de Gràcia '.$str2.', Barcelona';
            $user->avatar = 'default_avatar.jpg';
            $user->availability = 'Not implemented yet';
            $user->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
            $add_encoded = Geocoding::geocode($user->address);
            $user->lat = $add_encoded[0]; //latitud
            $user->lon = $add_encoded[1]; //longitud

            if(!($user->save()))
                dd('No se ha podido poblar la tabla de usuarios');

        }
        echo("Se ha poblado la tabla usuarios, estudiantes y profesores<br>");
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
                $i2 += 5;
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
        echo("Se ha poblado la tabla de materias<br>");
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
        echo("Se ha poblado la tabla de clases de profesores<br>");
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
        echo("Se ha poblado la tabla de clases de academias<br>");
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

}