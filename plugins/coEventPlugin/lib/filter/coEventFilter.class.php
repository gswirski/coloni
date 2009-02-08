<?php

class coEventFilter extends sfFilter
{
  public function execute(sfFilterChain $filterChain)
  {
    $filterChain->execute();
  }
}