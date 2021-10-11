<?php
$user = 'hilton';
$password = '#Hmm010903';
$domain = 'cartorio.int';
$basedn = 'dc=cartorio,dc=int';
$group = 'adnAdmin';
 
$ad = ldap_connect("ldap://{$domain}") or die('{"cod" : "1", "msg" : "Não foi possivel de conectar o LDAP Server"}');
 
ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
 
$bind = @ldap_bind($ad, "{$user}@{$domain}", $password) or die('{"cod" : "2", "msg" : "Erro ao logar, usuário ou senha inválidos"}');


if($bind){
    $userdn = getDN($ad, $user, $basedn);
    //echo getCN($userdn);
    if (checkGroupEx($ad, $userdn, getDN($ad, $group, $basedn))){
        echo '{"cod" : "3", "msg" : "Usuário conectado, com privilégio"}';
    } else {
        echo '{"cod" : "4", "msg" : "Usuário conectado, sem privilégio"}';
    }
//ldap_unbind($ad);
}
 
/**
 * This function searchs in LDAP tree entry specified by samaccountname and
 * returns its DN or epmty string on failure.
 *
 * @param resource $ad
 *          An LDAP link identifier, returned by ldap_connect().
 * @param string $samaccountname
 *          The sAMAccountName, logon name.
 * @param string $basedn
 *          The base DN for the directory.
 * @return string
 */
function getDN($ad, $samaccountname, $basedn)
{
  $result = ldap_search($ad, $basedn, "(samaccountname={$samaccountname})", array(
    'dn'
  ));
  if (! $result)
  {
    return '';
  }
 
  $entries = ldap_get_entries($ad, $result);
  if ($entries['count'] > 0)
  {
    return $entries[0]['dn'];
  }
 
  return '';
}
 
/**
 * This function retrieves and returns Common Name from a given Distinguished
 * Name.
 *
 * @param string $dn
 *          The Distinguished Name.
 * @return string The Common Name.
 */
function getCN($dn)
{
  preg_match('/[^,]*/', $dn, $matchs, PREG_OFFSET_CAPTURE, 3);
  return $matchs[0][0];
}
 
/**
 * This function checks group membership of the user, searching only in
 * specified group (not recursively).
 *
 * @param resource $ad
 *          An LDAP link identifier, returned by ldap_connect().
 * @param string $userdn
 *          The user Distinguished Name.
 * @param string $groupdn
 *          The group Distinguished Name.
 * @return boolean Return true if user is a member of group, and false if not
 *         a member.
 */
function checkGroup($ad, $userdn, $groupdn)
{
  $result = ldap_read($ad, $userdn, "(memberof={$groupdn})", array(
    'members'
  ));
  if (! $result)
  {
    return false;
  }
 
  $entries = ldap_get_entries($ad, $result);
 
  return ($entries['count'] > 0);
}
 
/**
 * This function checks group membership of the user, searching in specified
 * group and groups which is its members (recursively).
 *
 * @param resource $ad
 *          An LDAP link identifier, returned by ldap_connect().
 * @param string $userdn
 *          The user Distinguished Name.
 * @param string $groupdn
 *          The group Distinguished Name.
 * @return boolean Return true if user is a member of group, and false if not
 *         a member.
 */
function checkGroupEx($ad, $userdn, $groupdn)
{
  $result = ldap_read($ad, $userdn, '(objectclass=*)', array(
    'memberof'
  ));
  if (! $result)
  {
    return false;
  }
 
  $entries = ldap_get_entries($ad, $result);
  if ($entries['count'] <= 0)
  {
    return false;
  }
 
  if (empty($entries[0]['memberof']))
  {
    return false;
  }
 
  for ($i = 0; $i < $entries[0]['memberof']['count']; $i ++)
  {
    if ($entries[0]['memberof'][$i] == $groupdn)
    {
      return true;
    }
    elseif (checkGroupEx($ad, $entries[0]['memberof'][$i], $groupdn))
    {
      return true;
    }
  }
 
  return false;
}
