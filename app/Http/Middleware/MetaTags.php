<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cookie;

class MetaTags
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $metas = [
            'en' => [
                '/'=>[
                    'title' => 'Grand Community, influencer marketing is now easier',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'Grand Community, the top influencer marketing and campaign management platform, Grow your business now with persuasive campaigns lead by worldwide celebrities' ],
                        [ 'property'=>'og:title', 'content'=> 'Grand Community, influencer marketing is now easier' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/home_en.jpg') ]
                    ]
                ],
                'contact'=>[
                    'title' => 'Contact us',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'Our team is happy to answer your questions and queries anytime throughout the day, fill out this form to contact us, and we’ll follow up with you immediately' ],
                        [ 'property'=>'og:title', 'content'=> 'Contact us' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/contact_en.jpg') ]
                    ]
                ],
                'sponsers'=>[
                    'title' => 'Our Sponsors',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'We’re proudly trusted by a lot of your favorite brands, the list of our sponsors consists of over 200 local and international brands, view our sponsors here' ],
                        [ 'property'=>'og:title', 'content'=> 'Our Sponsors' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/sponsers_en.jpg') ]
                    ]
                ],
                'login'=>[
                    'title' => 'Log in to Grand Community',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'Log in to your account now, and get access to detailed reports about your campaigns, calendar of future projects, wishlist, messages, notifications, and more' ],
                        [ 'property'=>'og:title', 'content'=> 'Log in to Grand Community' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/login_en.jpg') ]
                    ]
                ],
                'register'=>[
                    'title' => 'Sign up now',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'Create an account now and start connecting and sharing with other people in your community, and showcase your products and services and more, all in one place' ],
                        [ 'property'=>'og:title', 'content'=> 'Sign up now' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/register_en.jpg') ]
                    ]
                ],
            ],
            'ar' => [
                '/'=>[
                    'title' => 'التسويق من خلال المشاهير والمؤثرين أصبح أسهل | جراند كومينتي',
                    'meta'=> [
                            [ 'name' => 'description', 'content' => 'جراند كومينيتي هي المنصة الأولى للتسويق من خلال المؤثرين وإدارة الحملات, تقدم بعملك الآن مع حملات إعلانية مؤثرة بالتعاون مع مشاهير عالميين وابدأ في 24 ساعة فقط' ],
                            [ 'property'=>'og:title', 'content'=> 'التسويق من خلال المشاهير والمؤثرين أصبح أسهل | جراند كومينتي' ],
                            [ 'property'=>'og:image', 'content'=> asset('meta_images/home_ar.jpg') ]
                    ]
                ],
                'contact'=>[
                    'title' => 'تواصل معنا',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'نسعد بالرد على أسئلتك واستفساراتك في أي وقت خلال اليوم، قم بتعبئة النموذج للتواصل معنا وسيقوم فريقنا المتخصص بالمتابعة معك والرد على استفساراتك على الفور' ],
                        [ 'property'=>'og:title', 'content'=> 'تواصل معنا' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/contact_ar.jpg') ]
                    ]
                ],
                'sponsers'=>[
                    'title' => 'الرعاة الرسميين لجراند كومينيتي',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'نفتخر بكوننا موثوق بنا من قبل الكثير من العلامات التجارية المفضلة لديك، حيث تتكون قائمة رعاتنا الرسميين من أكثر من 200 علامة تجارية محلية ودولية، شاهدهم هنا' ],
                        [ 'property'=>'og:title', 'content'=> 'الرعاة الرسميين لجراند كومينيتي' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/sponsers_ar.jpg') ]
                    ]
                ],
                'login'=>[
                    'title' => 'قم بتسجيل الدخول إلى جراند كومينيتي',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'م بتسجيل الدخول إلى حسابك الآن، وتمكن من الوصول إلى تقارير مفصلة عن حملاتك الإعلانية، وقائمة المشاريع المستقبلية، وقائمة الرسائل، والإشعارات، والمزيد' ],
                        [ 'property'=>'og:title', 'content'=> 'قم بتسجيل الدخول إلى جراند كومينيتي' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/login_ar.jpg') ]
                    ]
                ],
                'register'=>[
                    'title' => 'أنشئ حساب جديد الآن',
                    'meta'=> [
                        [ 'name' => 'description', 'content' => 'نشئ حسابك الآن في دقائق، وابدأ في المشاركة والتواصل مع أشخاص ومؤثرين آخرين في مجالك، وابدأ في عرض علامتك التجارية ومنتجاتك وخدماتك، كل ذلك في مكان واحد' ],
                        [ 'property'=>'og:title', 'content'=> 'أنشئ حساب جديد الآن' ],
                        [ 'property'=>'og:image', 'content'=> asset('meta_images/register_ar.jpg') ]
                    ]
                ],
            ]
        ];


        $path = $request->path();
        $returnTag = [];
        if($path == '/' || $path == 'ar' || $path == 'en'){
            $returnTag = $metas[app()->getLocale()]['/'];
        }elseif ($path == 'contact' || $path == 'ar/contact' || $path == 'en/contact'){
            $returnTag = $metas[app()->getLocale()]['contact'];
        }elseif ($path == 'sponsers' || $path == 'ar/sponsers' || $path == 'en/sponsers'){
            $returnTag = $metas[app()->getLocale()]['sponsers'];
        }elseif ($path == 'login' || $path == 'ar/login' || $path == 'en/login'){
            $returnTag = $metas[app()->getLocale()]['login'];
        }elseif ($path == 'register' || $path == 'ar/register' || $path == 'en/register'){
            $returnTag = $metas[app()->getLocale()]['register'];
        }else{
            $returnTag = $metas[app()->getLocale()]['/'];
        }
        $request->merge(compact('returnTag'));

        return $next($request);
    }


}
