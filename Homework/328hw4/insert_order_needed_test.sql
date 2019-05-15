
/*=====
  testing script for function insert_order_needed

  by: Sharon Tuttle
  last modified: 2018-02-11
=====*/

set serveroutput on

prompt
prompt *********************************
prompt TESTING insert_order_needed
prompt *********************************
prompt

-- turning feedback OFF for this call to start
--     pop-bks.sql -- we don't REALLY need to see
--     pop-bks.sql's rows-deleted and rows-inserted
--     feedback right now...
-- (but turning feedback back ON right afterward!)

set feedback off
@ pop-bks
set feedback 6

update title
set    qty_on_hand = qty_on_hand - 5
where  isbn = '0805322272';

exec insert_order_needed('0805322272', 50)

prompt
prompt =============================================================
prompt test passes if there is now an order_needed row for 
prompt     0805322272, for 50 copies, with date_created of today, 
prompt     and date_placed that is empty/null
prompt =============================================================
prompt

select *
from   order_needed;

prompt undoing temporary testing changes

rollback;
 
-- end of insert_order_needed_test.sql
