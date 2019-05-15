
/*=====
  testing script for function next_ord_needed_id

  NOTE:
      *   assumes that create-bks.sql and pop-bks.sql have been run

  by: Sharon Tuttle
  last modified: 2019-02-10
=====*/

set serveroutput on

prompt
prompt *****************************************
prompt TESTING next_ord_needed_id
prompt *****************************************
prompt

prompt test passes if the next ord_needed_id suggested is 1011:
prompt ==========================================================

var result_key number
exec :result_key := next_ord_needed_id()
print result_key

commit;

-- temporarily remove all rows from order_needed

delete from order_needed;

prompt
prompt test passes if the next ord_needed_id suggested is 1:
prompt ==========================================================

exec :result_key := next_ord_needed_id
print result_key

-- "put back" all rows from order_needed

rollback;

-- temporarily modify a row from order_needed

update order_needed
set ord_needed_id = 2018
where ord_needed_id = 1006;

prompt
prompt test passes if the next ord_needed_id suggested is 2019:
prompt ==========================================================

exec :result_key := next_ord_needed_id()
print result_key

-- undo the temporary modification

rollback;

-- end of next_ord_needed_test.sql
