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
        File::put(public_path().'/sitemap.xml', $sitemapView); //Save view as XML. We are done!
        unset($tags);

        //Generate sitemaps/teacher-XXX.xml sitemaps for every 50000 rows
        $c = 1; //counted teachers
        $i = 1; //counted sitemap files
        $teachers = Teacher::all();
        $n = $teachers->count();

        foreach($teachers as $t){
            if ($c % 50000 == 0) {
                $sitemapView = View::make('sitemap', compact('tags'))->render();
                File::put(public_path().'/sitemaps/teachers-'.$i.'.xml', $sitemapView);
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
                File::put(public_path().'/sitemaps/teachers-'.$i.'.xml', $sitemapView);
                unset($tags);
                break;
            } //no more -> new sitemap

            ++$c;
        }

        $now = Carbon::now();

        //Generate sitemaps/teacher.xml sitemap index that links all the generated teachers sitemaps
        for($j=1;$j<($i+1);++$j) {
            $sitemaps[] = [
                'loc'       => URL::to('/').'/sitemaps/teachers-'.$j.'.xml',
                'lastmod'   => $now
            ];
        }
        $sitemapView = View::make('sitemaps', compact('sitemaps'))->render();
        File::put(public_path().'/sitemaps/teacher.xml', $sitemapView);
        unset($sitemaps);

        //Generate sitemaps/school-XXX.xml sitemaps for every 50000 rows
        $c = 1; //counted schools
        $i = 1; //counted sitemap files
        $schools = School::all();
        $n = $schools->count();

        foreach($schools as $s){
            if($c % 50000 == 0) {
                $sitemapView = View::make('sitemap', compact('tags'))->render();
                File::put(public_path().'/sitemaps/schools-'.$i.'.xml', $sitemapView);
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
                File::put(public_path().'/sitemaps/schools-'.$i.'.xml', $sitemapView);
                unset($tags);
                break;
            } //no more -> new sitemap

            ++$c;
        }

        //Generate sitemaps/school.xml sitemap index that links all the generated teachers sitemaps
        for($j=1;$j<($i+1);++$j) {
            $sitemaps[] = [
                'loc'       => URL::to('/').'/sitemaps/schools-'.$j.'.xml',
                'lastmod'   => $now
            ];
        }
        $sitemapView = View::make('sitemaps', compact('sitemaps'))->render();
        File::put(public_path().'/sitemaps/school.xml', $sitemapView);
        unset($sitemaps);

        return 'Done!';
    }

//    //Render Sitemaps index
//    public function index() //Route::get('sitemap', 'SitemapsController@index');
//    {
//        // Examples:
//        // Get a sitemap via URL >>> Sitemap::addSitemap('/sitemaps/general');
//        // Get a sitemap via route helpers >>> Sitemap::addSitemap(URL::route('sitemaps.posts'));
//
//        Sitemap::addSitemap(URL::route('sitemaps-main'));
//        Sitemap::addSitemap(URL::route('sitemaps-teachers'));
//        Sitemap::addSitemap(URL::route('sitemaps-schools'));
//
//        return Sitemap::renderSitemapIndex();
//    }
//
//    //Render Sitemap for home and other main pages
//    public function main() {
//
//        //Home
//        $timestamp = date('c', File::lastModified(app_path().'/views/home.blade.php'));
//        Sitemap::addTag(URL::route('home'), $timestamp, 'monthly', '0.5');
//        //Who
//        $timestamp = date('c', File::lastModified(app_path().'/views/who.blade.php'));
//        Sitemap::addTag(URL::route('who'), $timestamp, 'monthly', '0.5');
//        //FAQs
//        $timestamp = date('c', File::lastModified(app_path().'/views/faqs.blade.php'));
//        Sitemap::addTag(URL::route('faqs'), $timestamp, 'monthly', '0.5');
//        //Contact
//        $timestamp = date('c', File::lastModified(app_path().'/views/contact.blade.php'));
//        Sitemap::addTag(URL::route('contact'), $timestamp, 'monthly', '0.5');
//
//        return Sitemap::renderSitemap();
//    }
//
//    //Render Sitemap for all teachers profiles
//    public function teachers()
//    {
//        $teachers = Teacher::all();
//
//        foreach ($teachers as $t)
//        {
//            $slug = $t->user->slug;
//            $lastmod = $t->user->updated_at;
//            Sitemap::addTag(URL::route('profiles-teacher', $slug), $lastmod, 'monthly', '0.1');
//        }
//
//        return Sitemap::renderSitemap();
//    }
//
//    //Render Sitemap for all schools profiles
//    public function schools()
//    {
//        $schools = School::all();
//
//        foreach ($schools as $s)
//        {
//            $slug = $s->slug;
//            $lastmod = $s->updated_at;
//            Sitemap::addTag(URL::route('profiles-school', $slug), $lastmod, 'monthly', '1.0');
//        }
//
//        return Sitemap::renderSitemap();
//    }
//
//    public function renderXMLSitemap()
//    { //call all other methods at once
//        $this->main();
//        $this->teachers();
//        $this->schools();
//
//        File::put(public_path().'/sitemap.xml', Sitemap::xml());
//
//        return 'Done!';
//    }
}