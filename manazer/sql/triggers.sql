show triggers from manazer;

drop trigger platba_copy;


delimiter //
create trigger nova_transakce after insert 
on pravidelne_platby for each row
call nova_prav_trans(new.idprav_platby) //
delimiter ;


delimiter //
create trigger prav_platba_update before update
on pravidelne_platby for each row
begin
update trans_historie set platba_status='cancel' where platba_id=old.idprav_platby and platba_status='cekajici';
call nova_prav_trans(new.idprav_platby);
end //
delimiter ;


delimiter //
create trigger platba_copy before update
on trans_historie for each row
begin
declare frek int;
select frekvenceplateb into frek from pravidelne_platby where idprav_platby=new.platba_id;
if old.platba_status='cekajici' and new.platba_status = 'hotovo' and frek>0 then
update pravidelne_platby set datumpristiplatby=period_add(datumpristiplatby,frekvenceplateb) where idprav_platby=new.platba_id;
-- call nova_prav_trans(new.platba_id);
elseif new.platba_status = 'hotovo' and frek = 0 then
update pravidelne_platby set datumpristiplatby=Null where idprav_platby=new.platba_id;
end if;
end //
delimiter ;


delimiter //
create trigger prijem_insert after insert 
on prijem for each row

if new.typ = 'aktivni' then
update zdroje set pristi_vyplata_termin=period_add(pristi_vyplata_termin,1) where idzdroje=new.zdroj;
end if //
delimiter ;