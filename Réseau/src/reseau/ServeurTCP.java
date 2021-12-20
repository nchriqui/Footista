package reseau;
/**
 * Serveur TCP pour multiple clients
 */
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketTimeoutException;
import java.nio.BufferOverflowException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.sql.*;

public class ServeurTCP {


    public static void main (String argv []) throws IOException {
        ServerSocket serverSocket = null ;
        boolean listening = true ;
        String port ="";


        try {
        	BufferedReader buffer = new BufferedReader ( new InputStreamReader ( System.in)) ;;
        	System.out.println("Veuillez saisir le port du serveur (5000 par default) : ");
        	port = buffer.readLine();
        	if(port.equals(""))
        		port="5000";
        	int no_port=Integer.parseInt(port);
        	
            // premier argument : le numero de port sur lequel on ecoute
            serverSocket = new ServerSocket (no_port) ;
        }
        catch (IOException e) {
            System.err.println ("Je ne peux pas ecouter sur le port") ;
            System.exit (-1) ;
        }

        while (listening) {
            System.out.println("En attente de connexion d'un client");
            new ThreadRepeteur (serverSocket.accept ()).start () ;
        }
        serverSocket.close () ;
    }
}

class ThreadRepeteur extends Thread {
    private Socket clientSocket = null ;
    private static JDBC2 jdbc;

    public ThreadRepeteur (Socket clientSocket) {
        super ("ThreadRepeteur") ;
        this.clientSocket = clientSocket ;
    }

    public void run () {
        try {
        	clientSocket.setSoTimeout(60*1000); //durée d'inactivité max
            PrintWriter flux_sortie = new PrintWriter
                    (clientSocket.getOutputStream (), true) ;
            BufferedReader flux_entree = new BufferedReader (
                    new InputStreamReader (clientSocket.getInputStream ())) ;
            boolean est_co = true;
            
            System.out.println("Connexion etablie");
            String chaine_entree, chaine_sortie, nomclient ;
            flux_sortie.println ("Bonjour, qui etes vous ? ");
            nomclient = flux_entree.readLine();
			System.out.println ("Client > " + nomclient);
            if(nomclient.equals("Exit")) {
            	chaine_sortie = "Au revoir !" ;
                flux_sortie.println (chaine_sortie) ;
                est_co=false;
                flux_sortie.close () ;
                flux_entree.close () ;
                clientSocket.close () ;
            }
            else
            {
            	System.out.println ("Nom du client : " + nomclient);
       
            	flux_sortie.println ("Bienvenue " + nomclient + " !");            
            }
            
            while (est_co) {

            	chaine_entree = flux_entree.readLine();
    			System.out.println ("Client > " + chaine_entree);
                
                //DECONNECTION
                if (chaine_entree.equals ("Exit")) {
                    chaine_sortie = "Au revoir !" ;
                    flux_sortie.println (chaine_sortie) ;
                    break ;
                }
                
                //CONNAITRE LE CLUB D'UN JOUEUR
                else if(chaine_entree.equals("Connaitre club")) {
                	
                	chaine_sortie = "Quel est le nom du joueur ?";
                    flux_sortie.println (chaine_sortie) ;
                    chaine_entree = flux_entree.readLine();
        			System.out.println ("Client > " + chaine_entree);

                    String nom_joueur = chaine_entree;

                    chaine_sortie = "Quel est le prenom du joueur ?";
                    flux_sortie.println (chaine_sortie) ;
                    chaine_entree = flux_entree.readLine();
        			System.out.println ("Client > " + chaine_entree);

                    String prenom_joueur = chaine_entree;
                    
                    jdbc = new JDBC2();
                    
                    if(jdbc.countSQL(nom_joueur,prenom_joueur)){
                    	int no_joueur = jdbc.getNoJoueurSQL(nom_joueur, prenom_joueur);
                    	String nom_club = jdbc.getNameClubSQL(no_joueur);
                    	
                    	chaine_sortie = nom_joueur + " " + prenom_joueur 
                    			+" est dans le club : " + nom_club;
                        flux_sortie.println (chaine_sortie) ;
                    }
                    else
                    {
                        chaine_sortie = "ERREUR : le joueur n'existe pas";
                        flux_sortie.println (chaine_sortie);
                    }
                	
                }
                //FAIRE UN TRANSFERT
                else if(chaine_entree.equals("Transfert")) {

                    chaine_sortie = "Quel est le nom du joueur a tranferer ?";
                    flux_sortie.println (chaine_sortie) ;
                    chaine_entree = flux_entree.readLine();
        			System.out.println ("Client > " + chaine_entree);

                    String nom_joueur = chaine_entree;

                    chaine_sortie = "Quel est le prenom du joueur a tranferer ?";
                    flux_sortie.println (chaine_sortie) ;
                    chaine_entree = flux_entree.readLine();
        			System.out.println ("Client > " + chaine_entree);

                    String prenom_joueur = chaine_entree;

                    jdbc = new JDBC2();

                    if(jdbc.countSQL(nom_joueur,prenom_joueur)){
                        int no_joueur = jdbc.getNoJoueurSQL(nom_joueur, prenom_joueur);
                    	String nom_club = jdbc.getNameClubSQL(no_joueur);
                    	int no_club = jdbc.getNoClubSQL(nom_club);
                        chaine_sortie ="Le joueur est dans le club : "
                                + nom_club + "."
                                + " Voulez-vous effectuer un transfert ? (Oui ou Non)";
                        flux_sortie.println (chaine_sortie);

                        chaine_entree = flux_entree.readLine();
            			System.out.println ("Client > " + chaine_entree);

                        if(chaine_entree.equals("Oui") || chaine_entree.equals("oui"))
                        {
                            chaine_sortie ="Dans quel club voulez vous transferer "
                                    + prenom_joueur + " " + nom_joueur + " ?";
                            flux_sortie.println (chaine_sortie);

                            chaine_entree = flux_entree.readLine();
                			System.out.println ("Client > " + chaine_entree);


                            if(jdbc.countClubSQL(chaine_entree))
                            {
                                int no_nouveau_club = jdbc.getNoClubSQL(chaine_entree);

                                chaine_sortie ="Quel est le montant du tranfert ?";
                                flux_sortie.println (chaine_sortie);
                                chaine_entree = flux_entree.readLine();
                                String regex="[+]?[0-9][0-9]*";
                                Pattern p = Pattern.compile(regex);
                                Matcher m = p.matcher(chaine_entree);
                                if(m.find() && m.group().equals(chaine_entree))
                                {
                                	int montant = Integer.parseInt(chaine_entree);
                                	System.out.println ("Client > " + montant);
                                

                                	if(jdbc.updateSQL(no_nouveau_club,no_joueur) <= 0)
                                		System.out.println ("ERREUR");

                                	if(jdbc.insertTransfertSQL(montant, no_joueur, no_club, no_nouveau_club) <= 0)
                                		System.out.println("ERREUR2");
                                	
                                	String nouveau_club = jdbc.getNameClubSQL(no_joueur);


                                	chaine_sortie ="Transfert du joueur : "
                                        + prenom_joueur  + " "
                                        + nom_joueur
                                        + " dans le club : "
                                        + nouveau_club + ".";
                                	flux_sortie.println (chaine_sortie);
                                }
                                else
                                {
                                	chaine_sortie ="ERREUR : ce n'est pas un chiffre valide. Transfert annule. ";
                                    flux_sortie.println (chaine_sortie);
                                }
                               
                            }
                            else
                            {
                                chaine_sortie = "ERREUR : le club n'existe pas, transfert annule.";
                                flux_sortie.println (chaine_sortie);
                            }

                        }
                        else
                        {
                            chaine_sortie ="Transfert annule, le joueur est toujours dans le club : "
                                    + nom_club + ".";
                            flux_sortie.println (chaine_sortie);
                        }
                    }
                    else
                    {
                        chaine_sortie = "ERREUR : le joueur n'existe pas";
                        flux_sortie.println (chaine_sortie);
                    }
                }

                else {
                    chaine_sortie = "commande inconnue";
                    flux_sortie.println (chaine_sortie) ;

                }

            }

            flux_sortie.close () ;
            flux_entree.close () ;
            clientSocket.close () ;

        }
        catch (SocketTimeoutException e) {
            try {
				clientSocket.close() ;
				System.err.println("Delai d'attente de reponse client depasse !");
			} catch (IOException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
        }
        catch (BufferOverflowException e) {
        	System.err.println ("Dépassement de taille de Buffer");
			try {
				clientSocket.close() ;
			} catch (IOException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
        }
        catch (IOException e) { e.printStackTrace () ; }
        
    }
}
