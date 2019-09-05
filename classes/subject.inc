<?php
interface subject {
public function subscribe(observer $o);
public function unsubscribe(observer $o);
public function notify();
}
