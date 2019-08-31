<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class TaskControllerTest
 *
 * @package App\Tests
 */
class TaskControllerTest extends WebTestCase
{
    /**
     *  Test the routes of the app
     */
    public function testLinks()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/');


        // NavBar Link
        $link        = $crawler->filter('a:contains("Bloc Notes")')
                               ->link();
        $homeCrawler = $client->click($link);
        $this->assertContains('Accueil', $homeCrawler->filter('title')->text());

        // Edit Link
        $link        = $crawler->filter('a:contains("Éditer")')
                               ->link();
        $editCrawler = $client->click($link);
        $this->assertContains('Édition', $editCrawler->filter('title')->text());
    }

    /**
     *  Test the forms
     */
    public function testCrud()
    {
        $client = static::createClient();

        // Test Create Form
        $crawler = $client->request('GET', '/');
        $this->handleForm($crawler, $client, 'créée');


        // Test Edit Form
        $crawler = $client->request('GET', '/task/edit/faire-du-code');
        $this->handleForm($crawler, $client, 'éditée');       // Test Edit Form

        // Test Delete Code
        $crawler = $client->request('GET', '/');
        $form    = $crawler->selectButton('Supprimer')->form();

        $client->submit($form);
        $client->followRedirect();

        $this->assertContains('Votre tâche a bien été supprimée :-)', $client->getResponse()->getContent());
    }

    /**
     * Submit Task Form Create/edit
     *
     * @param Crawler $crawler
     * @param Client  $client
     * @param         $flash
     */
    private function handleForm(Crawler $crawler, Client $client, $flash)
    {
        $form = $crawler->selectButton('Enregistrer')->form();

        $form['task[name]']        = 'Faire du code!';
        $form['task[description]'] = 'Tâche ' . $flash;
        $form['task[endedAt]']     = '11-05-2021 20:00';

        $client->submit($form);
        $client->followRedirect();

        $this->assertContains('Votre tâche a bien été ' . $flash . ' :-)', $client->getResponse()->getContent());
    }
}
