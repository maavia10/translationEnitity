<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Tests\Controller;

class DefaultController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $request->setLocale('ar');
        $locale = $request->getLocale();
//        dump($locale);die;
        $em = $this->getDoctrine()->getManager();
        $totalArrayLocales = $this->getParameter('locales');
        $post = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();
        $em->getFilters()->disable('oneLocale');
//        dump($post);die;
        $output = array();
        foreach ($post as $posts) {
            $translations = $posts->getTranslations();
            $locales = $totalArrayLocales;
            foreach ($locales as $locale) {
                $output[$posts->getId()][$locale] = $translations->get($locale);
            }

        }
        return $this->render('default/index.html.twig', array(
            "totalLocale" => $totalArrayLocales,
            "translateAbleData"=>$output,
            "dataWithoutTranslation"=>$post,
            "selecedLocale"=>''
        ));
    }
    /**
     * @Route("/language", name="language")
     */
    public function languageChange(Request $request){
        $request->setLocale('ar');
        $selectedLocale=$request->get('languageDropDown',null);
        $locale = $request->getLocale();
//        dump($locale);die;
        $em = $this->getDoctrine()->getManager();
        $totalArrayLocales = $this->getParameter('locales');
        $post = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();
        $em->getFilters()->disable('oneLocale');
//        dump($post);die;
        $output = array();
        foreach ($post as $posts) {
            $translations = $posts->getTranslations();
            $locales = $totalArrayLocales;
            foreach ($locales as $locale) {
                $output[$posts->getId()][$selectedLocale] = $translations->get($selectedLocale);
            }

        }
//        dump($selectedLocale);die;
        return $this->render('default/index.html.twig', array(
            "totalLocale" => $totalArrayLocales,
            "translateAbleData"=>$output,
            "dataWithoutTranslation"=>$post,
            "selecedLocale"=>$selectedLocale
        ));
    }
}
