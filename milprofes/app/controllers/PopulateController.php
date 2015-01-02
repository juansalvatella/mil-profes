<?php

class PopulateController extends BaseController
{

    public function populate()
    { //Recomiendo ir descomentando y ejecutar métodos 1 a 1 debido a posibles errores y/o tiempos de ejecución excesivos

        //$this::populateStudents(); //30 escuelas
        //$this::populateTeachers(); //30 profesores
        //$this::populateSchools(); //30 estudiantes
        //$this::populateSubjects(); //7 materias

        //$this::populatePivotTeachersSubjects(); //1 o 2 materias relacionadas con cada profesor
        //$this::populatePivotSchoolsSubjects(); //1 o 2 materias relacionadas con cada academia

        //$this::populateLessons(); //90 lecciones/clases con 1 profesor (docente) y 1 materia relacionados
        //$this::populateRatings(); //90 ratings, con 1 clase (puntuada) y 1 estudiante (puntuador) relacionados
        echo('No more methods being called');

    } //This method only works on fresh created tables (if all ids starts counting from 1)

    private function populateStudents()
    {
        for ($i=0;$i<30;++$i)
        {
            $str = (string) $i;
            $student = new Student();
            $student->name = 'Nombre'.$str;
            $student->lastname = 'Varios Apellidos'.$str;
            $student->email = 'estudiante'.$str.'@email.com';
            $student->phone = '666 55 44 '.$str;
                if (!isset($i2)) { $i2 = 1; }
                $i2 += 5;
                $str2 = (string) $i2;
            $student->address = 'Passeig de Gràcia '.$str2.', Barcelona';
            $student->avatar = 'default_avatar.jpg';
            $student->availability = 'All night long';
            $student->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
            $add_encoded = Geocoding::geocode($student->address);
            $student->lat = $add_encoded[0]; //latitud
            $student->lon = $add_encoded[1]; //longitud
            if(!($student->save()))
                dd('No se ha podido poblar la tabla de estudiantes');
        }
        echo('1/8 Se ha poblado la tabla de estudiantes');
    }

    private function populateTeachers()
    {
        for ($i=0;$i<30;++$i)
        {
            $str = (string) $i;
            $teacher = new Teacher();
            $teacher->name = 'Profesor'.$str;
            $teacher->lastname = 'Chiflado Apellidos'.$str;
            $teacher->email = 'profesor'.$str.'@email.com';
            $teacher->phone = '999 88 77 '.$str;
                if (!isset($i2)) { $i2 = 1; }
                $i2 += 5;
                $str2 = (string) $i2;
            $teacher->address = 'Avenida Diagonal '.$str2.', Barcelona';
            $add_encoded = Geocoding::geocode($teacher->address);
            $teacher->lat = $add_encoded[0]; //latitud
            $teacher->lon = $add_encoded[1]; //longitud
            $teacher->avatar = 'default_avatar.jpg';
            $teacher->availability = 'All night long';
            $teacher->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
            if(!($teacher->save()))
                dd('No se ha podido poblar la tabla de profesores');
        }
        echo('2/8 Se ha poblado la tabla de profesores');
    }

    private function populateSchools()
    {
        for ($i=0;$i<30;++$i)
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
        echo('3/8 Se ha poblado la tabla de academias');
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
        echo('4/8 Se ha poblado la tabla de materias');
    }

    private function populatePivotTeachersSubjects()
    { //Many-to-many: teachers-subjects
        for ($i=1;$i<31;++$i)
        {
                $rint1 = (integer) rand(1,7);
                $rint2 = (integer) rand(1,7);
            $teacher = Teacher::findOrFail($i);
            if($rint1!=$rint2)
                $teacher->subjects()->sync(array($rint1,$rint2));
            else
                $teacher->subjects()->sync(array($rint1));
        }
        echo('5/8 Se ha poblado la tabla pivote profesores-materias');
    }

    private function populatePivotSchoolsSubjects()
    { //Many-to-many: schools-subjects
        for ($i=1;$i<31;++$i)
        {
                $rint1 = (integer) mt_rand(1,7);
                $rint2 = (integer) mt_rand(1,7);
            $school = School::findOrFail($i);
            if($rint1!=$rint2)
                $school->subjects()->sync(array($rint1,$rint2));
            else
                $school->subjects()->sync(array($rint1));
        }
        echo('6/8 Se ha poblado la tabla pivote academias-materias');
    }

    private function populateLessons()
    { //FK_ids, 1-Many: teacher, subject
        for ($i=0;$i<90;++$i)
        {
            $lesson = new Lesson();
                $rprice = (float) mt_rand(50,199)/10;
            $lesson->price = $rprice;
            $lesson->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
                $rid1 = (integer) mt_rand(1,30);
                $rid2 = (integer) mt_rand(1,7);
            $teacher = Teacher::findOrFail($rid1);
            $subject = Subject::findOrFail($rid2);
            $lesson->teacher()->associate($teacher);
            $lesson->subject()->associate($subject);
            if(!($lesson->save()))
                dd('No se ha podido poblar la tabla de lecciones');
        }
        echo('7/8 Se ha poblado la tabla de lecciones');
    }

    private function populateRatings()
    { //FK_ids, 1-Many: student, lesson
        for($i=0;$i<90;++$i)
        {
            $rating = new Rating();
                $nota = (float) mt_rand(0,100)/10;
            $rating->value = $nota;
            $rating->comment = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sem mi, pulvinar non sapien eget, rhoncus molestie nisi. Nam elit quam, iaculis sed tempor in, porta vitae elit. Nulla mattis ligula in nulla dignissim euismod at eu justo. Cras placerat leo vitae nisl bibendum, ut fringilla sapien laoreet. Proin nec varius enim. Quisque egestas arcu libero. Nulla facilisi. Cras a imperdiet justo. Etiam eu nisl erat. Suspendisse fermentum tristique justo. In quis finibus augue, at auctor dui. Integer id interdum eros.';
                $rid1 = (integer) mt_rand(1,30);
                $rid2 = (integer) mt_rand(1,90);
            $student = Student::findOrFail($rid1);
            $lesson = Lesson::findOrFail($rid2);
            $rating->student()->associate($student);
            $rating->lesson()->associate($lesson);
            if(!($rating->save()))
                dd('No se ha podido poblar la tabla de ratings');
        }
        echo('8/8 Se ha poblado la tabla de ratings');
    }

}