<?php

class PopulateController extends BaseController
{

    public function populate()
    {
        $this::populateTeachers();
        $this::populateStudents();
        $this::populateSchools();
        $this::populateSubjects();
        $this::populatePivotSchoolsSubjects();
        $this::populatePivotTeachersSubjects();
    }

    private function populateStudents()
    {
        for ($i=0;$i<10;++$i)
        {
            $str = (string) $i;
            $student = new Student();
            $student->name = 'Estudiante Clon Número'.$str;
            $student->email = 'stu_clon_'.$str.'@gmail.com';
            if (!isset($i2)) { $i2 = 0; }
            $i2 += 35;
            $str2 = (string) $i2;
            $student->address = 'Passeig de Gràcia '.$str2.', Barcelona';
            //$student->lat = '';
            //$student->long = '';
            var_dump($student->save());
        }
    }

    private function populateTeachers()
    {
        for ($i=0;$i<10;++$i)
        {
            $str = (string) $i;
            $teacher = new Teacher();
            $teacher->name = 'Profesor Clon Número'.$str;
            $teacher->rate = $str.' €';
            $teacher->schedule = 'Lunes y Miércoles de '.$str.'h a 12:00h';
            if (!isset($i2)) { $i2 = 0; }
            $i2 += 35;
            $str2 = (string) $i2;
            $teacher->address = 'Avenida Diagonal '.$str2.', Barcelona';
            //$teacher->lat = '';
            //$teacher->long = '';
            $teacher->email = 'tea_clon_'.$str.'@gmail.com';
            $teacher->tel = '999 88 77 6'.$str;
            $teacher->description = 'Sin descripción en cuanto a este profesor no.'.$str;
            var_dump($teacher->save());
        }
    }

    private function populateSchools()
    {
        for ($i=0;$i<10;++$i)
        {
            $str = (string) $i;
            $school = new School();
            $school->name = 'Academia Número'.$str;
            $school->rate = $str.' €';
            $school->schedule = 'Lunes a Viernes de '.$str.'h a 12:00h';
            if (!isset($i2)) { $i2 = 0; }
            $i2 += 35;
            $str2 = (string) $i2;
            $school->address = 'Avenida Meridiana '.$str2.', Barcelona';
            //$school->lat = '';
            //$school->long = '';
            $school->email = 'sch_'.$str.'@gmail.com';
            $school->cif = '98765432'.$str;
            $school->tel = '999 88 77 6'.$str;
            $school->description = 'Sin descripción en cuanto a esta academia no.'.$str;
            var_dump($school->save());
        }
    }

    private function populateSubjects()
    {
        $esenciales = array('escolar','cfp','universitario','artes','música','idiomas','deportes');
        for ($i=0;$i<sizeof($esenciales);++$i)
        {
            $subject = new Subject();
            $subject->name = $esenciales[$i];
            var_dump($subject->save());
        }
    }

    private function populatePivotTeachersSubjects()
    {
        for ($i=1;$i<11;++$i)
        {
            $rint1 = rand(1,7);
            $rint2 = rand(1,7);
            Teacher::find($i)->subjects()->sync(array($rint1,$rint2));
        }
    }

    private function populatePivotSchoolsSubjects()
    {
        for ($i=1;$i<11;++$i)
        {
            $rint1 = rand(1,7);
            $rint2 = rand(1,7);
            School::find($i)->subjects()->sync(array($rint1,$rint2));
        }
    }

}