<?php

class SitemapsController extends BaseController
{
    //Render Sitemaps index online
    public function index() //Route::get('sitemap', 'SitemapsController@index');
    {
        // Examples:
        // Get a sitemap via URL >>> Sitemap::addSitemap('/sitemaps/general');
        // Get a sitemap via route helpers >>> Sitemap::addSitemap(URL::route('sitemaps.posts'));

        Sitemap::addSitemap(URL::route('sitemaps-main'));
        Sitemap::addSitemap(URL::route('sitemaps-teachers'));
        Sitemap::addSitemap(URL::route('sitemaps-schools'));

        File::put(base_path().'/sitemaps_index.xml', Sitemap::xml());
        return Sitemap::renderSitemapIndex();
    }

    //Render Sitemap for home and other main pages
    public function main() {

        //Home
        $timestamp = date('c', File::lastModified(app_path().'/views/home.blade.php'));
        Sitemap::addTag(URL::route('home'), $timestamp, 'monthly', '0.5');
        //Who
        $timestamp = date('c', File::lastModified(app_path().'/views/who.blade.php'));
        Sitemap::addTag(URL::route('who'), $timestamp, 'monthly', '0.5');
        //FAQs
        $timestamp = date('c', File::lastModified(app_path().'/views/faqs.blade.php'));
        Sitemap::addTag(URL::route('faqs'), $timestamp, 'monthly', '0.5');
        //Contact
        $timestamp = date('c', File::lastModified(app_path().'/views/contact.blade.php'));
        Sitemap::addTag(URL::route('contact'), $timestamp, 'monthly', '0.5');

        return Sitemap::renderSitemap();
    }

    //Render Sitemap for all teachers profiles
    public function teachers()
    {
        $teachers = Teacher::all();

        foreach ($teachers as $t)
        {
            $slug = $t->user->slug;
            $lastmod = $t->user->updated_at;
            Sitemap::addTag(URL::route('profiles-teacher', $slug), $lastmod, 'monthly', '0.1');
        }

        return Sitemap::renderSitemap();
    }

    //Render Sitemap for all schools profiles
    public function schools()
    {
        $schools = School::all();

        foreach ($schools as $s)
        {
            $slug = $s->slug;
            $lastmod = $s->updated_at;
            Sitemap::addTag(URL::route('profiles-school', $slug), $lastmod, 'monthly', '1.0');
        }

        return Sitemap::renderSitemap();
    }

    public function renderXMLSitemap()
    { //call all other methods at once
        $this->main();
        $this->teachers();
        $this->schools();

        File::put(base_path().'/sitemap.xml', Sitemap::xml());

        return 'Done!';
    }
}