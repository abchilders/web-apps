
/*=====
  testing script for function pending_order_needed

  by: Sharon Tuttle
  last modified: 2018-02-11
=====*/

set serveroutput on

prompt
prompt **********************
prompt TESTING pending_order_needed
prompt **********************
prompt

commit;

update title
set qty_on_hand = qty_on_hand - 5
where isbn = '0805322272';

exec insert_order_needed('0805322272', 50)

prompt =============================================================
prompt test passes if returns true (IS a pending order_needed for
prompt     0805322272)
prompt =============================================================
prompt

var status_str varchar2(5);
exec :status_str := bool_to_string(pending_order_needed('0805322272'))
print status_str

prompt
prompt =============================================================
prompt test passes if returns false (order_needed row for
prompt     025602796X is NOT pending)
prompt =============================================================
prompt

exec :status_str := bool_to_string(pending_order_needed('025602796X'))
print status_str

prompt
prompt =============================================================
prompt test passes if returns false (0131103628 is a title,
prompt     but is not in order_needed table at all, so cannot
prompt     be pending)
prompt =============================================================
prompt

exec :status_str := bool_to_string(pending_order_needed('0131103628'))
print status_str

prompt
prompt =============================================================
prompt test passes if returns false (1111111111 is NOT a title,
prompt     so cannot be pending)
prompt =============================================================
prompt

exec :status_str := bool_to_string(pending_order_needed('1111111111'))
print status_str

prompt
prompt ========
prompt does it work for titles that have multiple previously-filled
prompt orders needed?
prompt ========
prompt

insert into order_needed
values
(1002, '0805343024', 10, sysdate-188, sysdate-185);

insert into order_needed
values
(1001, '0805343024', 10, sysdate-288, sysdate-285);

prompt
prompt ========
prompt 0805343024 now has 3 prior handled orders-needed,
prompt but none are pending;
prompt pending_order_needed test passes IF returns false:
prompt ========
prompt

exec :status_str := bool_to_string(pending_order_needed('0805343024'))
print status_str

/* now inserting an order needed for 0805343024 */

exec insert_order_needed('0805343024', 3);

prompt
prompt ========
prompt 0805343024 now has a pending order_needed in addition to
prompt its 3 prior handled orders-needed;
prompt pending_order_needed test passes IF now returns true:
prompt ========
prompt

exec :status_str := bool_to_string(pending_order_needed('0805343024'))
print status_str

prompt undoing temporary testing changes

rollback;

-- end of pending_order_needed_test.sql
