/* Alex Childers
   Last modified: 2019/02/06
*/

/* Function: bool_to_string: boolean -> varchar2
   Purpose: Expects a boolean value. Returns 'TRUE' if this Boolean value is 
	true, and returns 'FALSE' otherwise.
*/

create or replace function bool_to_string(bool_val boolean)
	return varchar2 as
begin
	if bool_val then
		return 'TRUE'; 
	else
		return 'FALSE';
	end if; 
end; 
/ 
show errors

spool hw2-1-out.txt

prompt =============
prompt Alex Childers
prompt =============
prompt
prompt ***bool_to_string(TRUE) should return 'TRUE':*** 

-- Test case for function bool_to_string(TRUE)
var 	string_test varchar2(10)
exec	:string_test := bool_to_string(TRUE)
print	string_test

prompt ***bool_to_string(FALSE) should return 'FALSE':*** 

-- Test case for function bool_to_string(FALSE)
exec	:string_test := bool_to_string(FALSE)
print	string_test

spool off
