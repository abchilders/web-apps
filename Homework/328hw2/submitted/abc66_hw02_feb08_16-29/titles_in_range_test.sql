
/*=====
  testing script for procedure titles_in_range

  by: Sharon Tuttle
  last modified: 2019-02-02
=====*/

prompt
prompt *********************************
prompt TESTING titles_in_range
prompt *********************************
prompt

set serveroutput on

prompt ==========================================================
prompt testing for titles whose price is in range [55, 75]
prompt ====> test passes if see:
prompt $55-Business Data Communications-3
prompt $55-Creating Effective Software-2
prompt $75-Simulation Modeling and Analysis-10
prompt ==========================================================
prompt

exec titles_in_range(55, 75)

prompt ==========================================================
prompt testing for titles whose price is in range [10, 15]
prompt ====> test passes if see:
prompt $14.95-Case Book for Data Base Management-50
prompt ==========================================================
prompt

exec titles_in_range(10, 15)

prompt ==========================================================
prompt testing for titles whose price is in range [30, 40]
prompt ====> test passes if see:
prompt $31.5-Financial Accounting-10
prompt $34.95-Computers and Data Processing-15
prompt $35.95-Operating Systems: A Systems Approa-5
prompt $37.95-An Introduction to Database Systems-10
prompt $37.95-Data Base Management-20
prompt $37.95-Problem Solving and Structures-12
prompt $39.95-The C Programming Language-10
prompt $40-Software Engineering-10
prompt ==========================================================
prompt

exec titles_in_range(30, 40)

prompt ==========================================================
prompt testing for titles whose price is in range [29.95, 29.95]
prompt ====> test passes if see:
prompt $29.95-BASIC: A Structured Approach-5
prompt ==========================================================
prompt

exec titles_in_range(29.95, 29.95)

prompt ==========================================================
prompt testing for titles whose price is in range [0, 10]
prompt ====> test passes if see NO output (there are no such titles):
prompt ==========================================================
prompt

exec titles_in_range(0, 10)

prompt ==========================================================
prompt testing for titles whose price is in range [40, 30]
prompt ====> test passes if see NO output (wrong parameters order):
prompt ==========================================================
prompt

exec titles_in_range(40, 30)

-- end of titles_in_range_test.sql
