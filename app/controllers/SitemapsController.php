<?php

use Carbon\Carbon;

class SitemapsController extends BaseController
{
    //Set priorities
    const PRI_HOME      = '0.5';
    const PRI_WHO       = '0.5';
    const PRI_FAQS      = '0.5';
    const PRI_CONTACT   = '0.5';
    const PRI_TEACHERS  = '0.1';
    const PRI_SCHOOLS   = '0.9';
    //Set frequencies
    const FREQ_HOME      = 'monthly';
    const FREQ_WHO       = 'monthly';
    const FREQ_FAQS      = 'monthly';
    const FREQ_CONTACT   = 'monthly';
    const FREQ_TEACHERS  = 'monthly';
    const FREQ_SCHOOLS   = 'monthly';
    
    public function milprofes()
    {
        // Generate sitemap.xml - Sitemap de las páginas informativas
        $timestamp['home'] = date('c', File::lastModified(app_path().'/views/home.blade.php'));
        $timestamp['who'] = date('c', File::lastModified(app_path().'/views/who.blade.php'));
        $timestamp['faqs'] = date('c', File::lastModified(app_path().'/views/faqs.blade.php'));
        $timestamp['contact'] = date('c', File::lastModified(app_path().'/views/contact.blade.php'));
        $tags[] = ['loc'=>URL::route('home'), 'lastmod'=>$timestamp['home'], 'changefreq'=>self::FREQ_HOME, 'priority'=>self::PRI_HOME]; //Home tag
        $tags[] = ['loc'=>URL::route('who'), 'lastmod'=>$timestamp['who'], 'changefreq'=>self::FREQ_WHO, 'priority'=>self::PRI_WHO]; //Who tag
        $tags[] = ['loc'=>URL::route('faqs'), 'lastmod'=>$timestamp['faqs'], 'changefreq'=>self::FREQ_FAQS, 'priority'=>self::PRI_FAQS]; //FAQs tag
        $tags[] = ['loc'=>URL::route('contact'), 'lastmod'=>$timestamp['contact'], 'changefreq'=>self::FREQ_CONTACT, 'priority'=>self::PRI_CONTACT]; //Contact tag
        $sitemapView = View::make('sitemap', compact('tags'))->render(); //Render view
//        File::put(public_path().'/sitemap.xml', $sitemapView);
        File::put(app_path('views').'/sitemap/sitemap.php', $sitemapView); //Save view as XML. We are done!
        unset($tags);

        //Generate sitemaps/teacher-XXX.xml sitemaps for every 50000 rows
        $c = 1; //counted teachers
        $i = 1; //counted sitemap files
        $teachers = Teacher::all();
        $n = $teachers->count();

        foreach($teachers as $t){
            if ($c % 50000 == 0) {
                $sitemapView = View::make('sitemap', compact('tags'))->render();
//                File::put(public_path().'/sitemaps/teachers-'.$i.'.xml', $sitemapView);
                File::put(app_path('views').'/sitemap/sitemaps/teachers-'.$i.'.php', $sitemapView);
                unset($tags);
                ++$i;
            } //every 50000 a new sitemap

            $slug = $t->user->slug;
            $lastmod = $t->user->updated_at;
            $tags[] = [
                'loc'           => URL::route('profiles-teacher', $slug),
                'lastmod'       => $lastmod,
                'changefreq'    => self::FREQ_TEACHERS,
                'priority'      => self::PRI_TEACHERS
            ]; //Current teacher tag

            if($c==$n) {
                $sitemapView = View::make('sitemap', compact('tags'))->render();
//                File::put(public_path().'/sitemaps/teachers-'.$i.'.xml', $sitemapView);
                File::put(app_path('views').'/sitemap/sitemaps/teachers-'.$i.'.php', $sitemapView);
                unset($tags);
                break;
            } //no more -> new sitemap

            ++$c;
        }

        $now = Carbon::now();

        //Generate sitemaps/teacher.xml sitemap index that links all the generated teachers sitemaps
        for($j=1;$j<($i+1);++$j) {
            $sitemaps[] = [
                'loc'       => URL::to('/').'/sitemaps/teachers-'.$j, //.xml
                'lastmod'   => $now
            ];
        }
        $sitemapView = View::make('sitemaps', compact('sitemaps'))->render();
//        File::put(public_path().'/sitemaps/teacher.xml', $sitemapView);
        File::put(app_path('views').'/sitemap/sitemaps/teacher.php', $sitemapView);
        unset($sitemaps);

        //Generate sitemaps/school-XXX.xml sitemaps for every 50000 rows
        $c = 1; //counted schools
        $i = 1; //counted sitemap files
        $schools = School::all();
        $n = $schools->count();

        foreach($schools as $s){
            if($c % 50000 == 0) {
                $sitemapView = View::make('sitemap', compact('tags'))->render();
//                File::put(public_path().'/sitemaps/schools-'.$i.'.xml', $sitemapView);
                File::put(app_path('views').'/sitemap/sitemaps/schools-'.$i.'.php', $sitemapView);
                unset($tags);
                ++$i;
            } //every 50000 (c) a new file

            $slug = $s->slug;
            $lastmod = $s->updated_at;
            $tags[] = [
                'loc'           => URL::route('profiles-school', $slug),
                'lastmod'       => $lastmod,
                'changefreq'    => self::FREQ_SCHOOLS,
                'priority'      => self::PRI_SCHOOLS
            ]; //Current school tag

            if($c==$n) {
                $sitemapView = View::make('sitemap', compact('tags'))->render();
//                File::put(public_path().'/sitemaps/schools-'.$i.'.xml', $sitemapView);
                File::put(app_path('views').'/sitemap/sitemaps/schools-'.$i.'.php', $sitemapView);
                unset($tags);
                break;
            } //no more -> new sitemap

            ++$c;
        }

        //Generate sitemaps/school.xml sitemap index that links all the generated teachers sitemaps
        for($j=1;$j<($i+1);++$j) {
            $sitemaps[] = [
                'loc'       => URL::to('/').'/sitemaps/schools-'.$j, //.xml
                'lastmod'   => $now
            ];
        }
        $sitemapView = View::make('sitemaps', compact('sitemaps'))->render();
//        File::put(public_path().'/sitemaps/school.xml', $sitemapView);
        File::put(app_path('views').'/sitemap/sitemaps/school.php', $sitemapView);
        unset($sitemaps);

        return 'Done!!!';
    }

}
