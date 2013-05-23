<?php

namespace Staple;

class Paginate implements \IteratorAggregate
{

  private $count = 0;
  private $current = 0;

  private $results = array();
  private $options = array(
              'link_text' => '%d',
              'link_href' => '?p=%d',
              'link_root' => '/',
              'count_max' => 13,
              'count_page' => 20,
            );

  private function __controller()
  {
  }

  public function getIterator()
  {
    return new \ArrayIterator($this->all());
  }

  public function __call($method, $arguments)
  {
    $callback = array($this->results, $method);

    if (is_callable($callback)) {
      return call_user_func_array($callback, $arguments);
    }

    throw new \Exception("Unable to execute '$method' callback");
  }

  public static function build()
  {
    return new static;
  }

  public function bind($set)
  {
    $this->results = $set;

    return $this;
  }

  public function set($key, $value = '')
  {
    if (is_array($key)) {
      $this->options = array_merge($this->options, $key);
    } elseif ($key instanceof \Closure) {
      $config = new stdClass;
      $key($config);

      $this->options = array_merge($this->options, (array) $config);
    } elseif ( $key && ! is_numeric($key)) {
      $this->options[$key] = $value;
    }
  }

  public function get($key, $default = FALSE)
  {
    return ! empty($this->options[$key]) ? $this->options[$key] : $default;
  }

  public function total()
  {
    return (int) $this->count;
  }

  public function pages()
  {
    return ceil($this->count / $this->get('count_page'));
  }

  public function count_page()
  {
    return (int) $this->get('count_page');
  }

  public function count_max()
  {
    return (int) $this->get('count_max');
  }

  public function current()
  {
    return $this->current ? (int) $this->current : 1;
  }

  public function offset($count, $current = FALSE)
  {
    $this->count = (int) $count;

    if ($current !== FALSE) {
      $this->current = (int) $current;
    }

    $index = $this->current ? $this->current - 1 : $this->current;
    $index = floor($index * $this->get('count_page'));

    return $index;
  }

  public function links($wrap = '[%s]')
  {
    $out = array();
    $end = $this->pages();
    $cur = $this->current();

    for ($i = 1; $i <= $end; $i += 1) {
      $link = $this->link($i, $this->get('link_text'));

      if ($cur === $i) {
        $link = sprintf($wrap, $link);
      }
      $out []= $link;
    }

    return $out;
  }

  public function link($num, $text = '', array $args = array())
  {
    $text = $text ? sprintf($this->get('link_text'), number_format($num)) : number_format($num);

    return tag('a', $this->url_for($num), $text);
  }

  public function url_for($num)
  {
    return sprintf($num <= 1 ? $this->get('link_root') : $this->get('link_href'), $num);
  }

  public function prev_url()
  {
    return $this->current() > 1 ? $this->url_for($this->current() - 1) : FALSE;
  }

  public function next_url()
  {
    return $this->current() < $this->pages() ? $this->url_for($this->current() + 1) : FALSE;
  }

  public function step($from = 0)
  {
    $out = 0;
    $max = $this->count_max();
    $end = $this->current() + $from;

    for ($i = 0; $i < $end; $i += 1) {
      if (($i % $max) === 1) {
        $out += 1;
      }
    }

    if ($out > 0) {
      $out -= 1;
    }

    return $out;
  }

}
