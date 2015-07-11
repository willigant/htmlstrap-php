HTMLStrap-PHP
=============

Quickly make Bootstrap html elements from common data types in PHP

```PHP
$messages_table = new table($data)
                ->hide_columns('user_id','updated_at')
                ->rename_column('phone_number','Phone Number')
                ->add_delete_column('/message/remove/')
                ->condensed()
                ->striped();

                echo $messages_table; // some bootstrapy table
 ```
