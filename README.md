# liblog
メニュー履歴ライブラリ

# need "libdb.php"

# How to use
Create object of MenuLog Class.
	ex) $log = new MenuLog( host, user, pass, user_id );

Use ResistMenuLog to resist menu log to database.
The method returns true if the method can resist log to database.
	ex) $decision =  $log->ResistMenuLog( user_id, log_list );

Use GetMenuLog to get menu log from database
The method returns array that like log_list if the method can get log from database.
	ex) $menulog = $
