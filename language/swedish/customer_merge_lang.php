<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Module name
$lang['customer_merge'] = 'Kundsammanslagning';
$lang['merge_customers'] = 'Slå samman kunder';
$lang['merge_new_customers'] = 'Slå samman nya kunder';

// Permissions
$lang['permission_view_customer_merge'] = 'Visa kundsammanslagning';
$lang['permission_create_customer_merge'] = 'Skapa kundsammanslagning';
$lang['customer_merge_permission_notice'] = 'Du har inte behörighet att slå samman kunder. Kontakta din administratör om du behöver denna åtkomst.';

// Merge page
$lang['source_customer'] = 'Källkund';
$lang['target_customer'] = 'Målkund';
$lang['will_be_deleted'] = 'Kommer att raderas';
$lang['will_be_kept'] = 'Kommer att behållas';
$lang['select_customer'] = 'Välj kund';
$lang['search_customers'] = 'Sök kunder';
$lang['customer_id'] = 'Kund-ID';
$lang['merge_options'] = 'Sammanslagningsalternativ';
$lang['data_to_merge'] = 'Data att slå samman';
$lang['customer_data_to_transfer'] = 'Kunddata att överföra';
$lang['customer_data_transfer_info'] = 'Välj vilken data från källkunden som ska överföras till målkunden (endast om målkunden inte redan har denna data).';
$lang['billing_details'] = 'Faktureringsuppgifter';
$lang['shipping_details'] = 'Leveransuppgifter';
$lang['customer_default_currency'] = 'Standardvaluta';
$lang['warning'] = 'Varning';
$lang['customer_merge_warning'] = 'Denna åtgärd kommer att slå samman källkunden med målkunden. All data från källkunden kommer att överföras till målkunden, och källkunden kommer att raderas. Denna åtgärd kan inte ångras.';
$lang['confirm_merge'] = 'Jag förstår att denna åtgärd inte kan ångras och jag vill fortsätta med sammanslagningen.';
$lang['confirm_merge_prompt'] = 'Är du säker på att du vill slå samman dessa kunder? Denna åtgärd kan inte ångras.';
$lang['wait_text'] = 'Vänligen vänta...';

// Primary contact note
$lang['primary_contact_note_title'] = 'Information om primär kontakt';
$lang['primary_contact_note'] = 'Vid sammanslagning av kunder kommer målkundens primära kontakt att behållas som primär kontakt. Eventuella primära kontakter från källkunden kommer att överföras men kommer inte längre att markeras som primära.';

// Success/error messages
$lang['customer_merge_success'] = 'Kunder har slagits samman framgångsrikt.';
$lang['customer_merge_failed'] = 'Misslyckades med att slå samman kunder.';
$lang['customer_merge_db_error'] = 'Databasfel uppstod under sammanslagningen. Kontrollera aktivitetsloggen för detaljer.';
$lang['customer_merge_select_both'] = 'Välj både käll- och målkund.';
$lang['customer_not_found'] = 'Kunden hittades inte.';
$lang['access_denied'] = 'Åtkomst nekad.';

// Merge history
$lang['no_merge_history'] = 'Ingen sammanslagningshistorik hittades.';
$lang['source_customer'] = 'Källkund';
$lang['target_customer'] = 'Målkund';
$lang['merged_by'] = 'Sammanslagen av';
$lang['merged_data'] = 'Sammanslagen data';
$lang['date'] = 'Datum';

$lang['always_merged'] = 'Alltid sammanslagen';
$lang['contacts_merge_info'] = 'Alla kontakter kommer att överföras. Om en kontakt med samma e-post finns hos målkunden kommer deras behörigheter och data att slås samman.';
$lang['tasks'] = 'Uppgifter';
$lang['payments'] = 'Betalningar';
$lang['statement'] = 'Utdrag';
$lang['profile'] = 'Profil';
$lang['source'] = 'Källa';
$lang['target'] = 'Mål';

// Module information
$lang['module_developed_by'] = 'Utvecklad av';
$lang['module_version'] = 'Version';
$lang['support'] = 'Support';

// Rollback functionality
$lang['rollback_merge'] = 'Återställ sammanslagning';
$lang['confirm_rollback_merge'] = 'Är du säker på att du vill återställa denna sammanslagning? Detta kommer att skapa en ny kund med det ursprungliga namnet och flytta tillbaka nyligen tillagd data.';
$lang['rollback_successful'] = 'Återställning av sammanslagning lyckades. En ny kund har skapats med originaldata.';
$lang['rollback_failed'] = 'Misslyckades med att återställa sammanslagningen.';
$lang['merge_history_not_found'] = 'Sammanslagningshistorik hittades inte.';
$lang['target_customer_not_found'] = 'Målkunden hittades inte. Den kan ha raderats.';
$lang['failed_to_recreate_source_customer'] = 'Misslyckades med att återskapa källkunden.';
$lang['invalid_merge_history_id'] = 'Ogiltigt ID för sammanslagningshistorik.';
$lang['merge_already_rolled_back'] = 'Denna sammanslagning har redan återställts.';
$lang['rolled_back'] = 'Återställd';
$lang['active'] = 'Aktiv';
$lang['status'] = 'Status';
$lang['options'] = 'Alternativ'; 