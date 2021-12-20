package reseau;
/**
 * Client TCP
 */

import java.io.IOException ;
import java.io.BufferedReader ;
import java.io.InputStreamReader ;
import java.io.PrintWriter ;
import java.io.IOException ;
import java.net.ServerSocket;
import java.net.Socket ;
import java.net.SocketException;
import java.net.SocketImpl;
import java.net.SocketTimeoutException;
import java.net.UnknownHostException ;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class ClientTCP {
    public static void main (String argv []) throws IOException {
    	
    	String port ="";
    	String ip="";
    	Socket socket = null ;
        PrintWriter flux_sortie = null ;
        BufferedReader flux_entree = null ;
        String chaine ;

        try {
        	//Info pour la connection
        	BufferedReader buffer = new BufferedReader ( new InputStreamReader ( System.in)) ;;
        	System.out.println("Veuillez saisir l'IP du serveur (127.0.0.1 par default) : ");
        	ip = buffer.readLine();
        	if(ip.equals(""))
        		ip="127.0.0.1";
        	System.out.println("Veuillez saisir le port du serveur (5000 par default) : ");
        	port = buffer.readLine();
        	if(port.equals(""))
        		port="5000";
        	int no_port=Integer.parseInt(port);
        	
            // Connection
            socket = new Socket (ip, no_port) ;

        	flux_sortie = new PrintWriter (socket.getOutputStream (), true) ;
            flux_entree = new BufferedReader (new InputStreamReader (
                                        socket.getInputStream ())) ;   
        } 
        catch (UnknownHostException e) {
            System.err.println ("Hote inconnu") ;
            System.exit (1) ;
        }
        catch (SocketException e) {
        	System.err.println ("Ip non accesible ou port non ouvert");
        	System.exit(1);
        }

	// L'entree standard
        BufferedReader entree_standard = new BufferedReader ( 
        		new InputStreamReader ( System.in)) ; 
        
//--------------------------------------------------------------------------------------------------
//ECHANGE
        try {
        socket.setSoTimeout(60*1000);
        chaine = flux_entree.readLine () ;
        System.out.println ("Le serveur me dit : " + chaine) ;
        do {
        	if(chaine.equals("Quel est le montant du tranfert ?"))
        	{
        		String regex="[+]?[0-9][0-9]*";
        		Pattern p = Pattern.compile(regex);
        		// on lit ce que l'utilisateur a tape sur l'entree standard
        		chaine = entree_standard.readLine () ;
        		Matcher m = p.matcher(chaine);
        		while(m.find()!=true ||  m.group().equals(chaine)!=true)
        		{
        			System.out.println("Vous devez entrer un nombre positif.");
					chaine = entree_standard.readLine () ;
					m = p.matcher(chaine);
        		}
        	}
        	else
        		chaine = entree_standard.readLine () ; 	// on lit ce que l'utilisateur a tape sur l'entree standard


        	// et on l'envoie au serveur
        	flux_sortie.println (chaine) ;

        	// on lit ce qu'a envoye le serveur
        	chaine = flux_entree.readLine () ;

        	// et on l'affiche a l'ecran
        	System.out.println ("Le serveur m'a repondu : " + chaine) ;
        } while (chaine != null && chaine.equals("Au revoir !")!=true) ;

        flux_sortie.close () ;
        flux_entree.close () ;
        entree_standard.close () ;
        socket.close () ;
        }
        catch(SocketTimeoutException e)
        {
        	socket.close();
        	System.err.println("Delai d'attente de reponse serveur depasse !");
        }
    }
}
