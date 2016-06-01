<?php
namespace Cyberduck\LaravelWpApi;

use GuzzleHttp\ClientInterface;

class WpApi
{

    protected $client;

    public function __construct($endpoint, ClientInterface $client, $auth = null)
    {
        $this->endpoint = $endpoint;
        $this->client   = $client;
        $this->auth     = $auth;
    }

    public function posts($page = null)
    {
        return $this->_get('posts', ['page' => $page]);
    }

    public function pages($page = null)
    {
        return $this->_get('posts', ['type' => 'page', 'page' => $page]);
    }

    public function post($slug)
    {
        return $this->_get('posts', ['filter' => ['name' => $slug]]);
    }

    public function page($slug)
    {
        return $this->_get('posts', ['type' => 'page', 'filter' => ['name' => $slug]]);
    }

    public function categories()
    {
        return $this->_get('taxonomies/category/terms');
    }

    public function tags()
    {
        return $this->_get('taxonomies/post_tag/terms');
    }

    public function categoryPosts($slug, $page = null)
    {
        return $this->_get('posts', ['page' => $page, 'filter' => ['category_name' => $slug]]);
    }

    public function authorPosts($name, $page = null)
    {
        return $this->_get('posts', ['page' => $page, 'filter' => ['author_name' => $name]]);
    }

    public function tagPosts($tags, $page = null)
    {
        return $this->_get('posts', ['page' => $page, 'filter' => ['tag' => $tags]]);
    }

    public function search($query, $page = null)
    {
        return $this->_get('posts', ['page' => $page, 'filter' => ['s' => $query]]);
    }

    public function archive($year, $month, $page = null)
    {
        return $this->_get('posts', ['page' => $page, 'filter' => ['year' => $year, 'monthnum' => $month]]);
    }

    public function _get($method, array $query = array())
    {
        try {
            $query = ['query' => $query];
            if ($this->auth) {
                $query['auth'] = $this->auth;
            }
            $response = $this->client->get($this->endpoint . $method, $query);
            $return = [
                'results' => json_decode($response->getBody()),
                'total'   => $response->getHeader('X-WP-Total'),
                'pages'   => $response->getHeader('X-WP-TotalPages')
            ];
        } catch (\GuzzleHttp\Exception\TransferException $e) {
            $error['message'] = $e->getMessage();
            if ($e->getResponse()) {
                $error['code'] = $e->getResponse()->getStatusCode();
            }
            $return = [
                'error'   => $error,
                'results' => [],
                'total'   => 0,
                'pages'   => 0
            ];
        }
        return $return;
    }
}
