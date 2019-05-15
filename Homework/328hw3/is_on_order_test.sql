
/*=====
  testing script for function is_on_order

  NOTES: 
      *   assumes that create-bks.sql and pop-bks.sql have been run

      *   uses function bool_to_string from Homework 2, Problem 1. 
          *   (An example version of bool_to_string will also be posted within
              bks-plsql.sql on the course Canvas site after Homework 2's 
              deadline has passed.)

  by: Sharon Tuttle
  last modified: 2019-02-10
=====*/

set serveroutput on

prompt
prompt *****************************************
prompt TESTING is_on_order (note: uses bool_to_string)
prompt *****************************************
prompt

prompt test passes if 0805343024 is shown on-order (returns true)
prompt ==========================================================

var on_order_status varchar2(5)
exec :on_order_status := bool_to_string(is_on_order('0805343024'))
print on_order_status

prompt
prompt test passes if 087150331X is shown NOT on-order (rets false)
prompt ==========================================================

exec :on_order_status := bool_to_string(is_on_order('087150331X'))
print on_order_status

prompt
prompt test passes if 1313131313 is shown NOT on-order (rets false)
prompt ==========================================================

exec :on_order_status := bool_to_string(is_on_order('1313131313'))
print on_order_status

-- end of is_on_order_test.sql
