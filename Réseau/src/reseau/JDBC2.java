package reseau;
import java.sql.*;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

public class JDBC2 {
    private final String url = PostgresConfig.jdbcUrl;
    private final String user = PostgresConfig.jdbcUser;
    private final String password = PostgresConfig.jdbcPassword;

    public Connection connect() {
        Connection connection = null;
        try {
        	DriverManager.setLoginTimeout(1);
            Class.forName("org.postgresql.Driver");
            connection = DriverManager.getConnection(url, user, password);
            System.out.println("Connected to the PostgreSQL server successfully.");
        } catch (SQLException e) {
       	 	System.err.println("timed response out");
        } catch (ClassNotFoundException e) {
            System.out.println(e.getMessage());
        }
        return connection;
    }
    
    //Est-ce que le joueur existe ?
    public boolean countSQL(String nom,String prenom) {
        String sql = "SELECT COUNT(*) FROM joueurs WHERE nom = ? and prenom = ?";
        int count = 0;
        try {
            Connection connection = connect();
            PreparedStatement pstatement = connection.prepareStatement(sql);

            pstatement.setString(1, nom);
            pstatement.setString(2, prenom);
            ResultSet rs = pstatement.executeQuery();
            rs.next();
            count = rs.getInt(1);
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return count > 0;
    }
    
    //Quel est le numéro du joueur ?
    public int getNoJoueurSQL(String nom_joueur,String prenom_joueur){
        String sql = ("SELECT no_joueur FROM joueurs WHERE nom = ? AND prenom = ? ");
        int count = 0;
        try {
            Connection connection = connect();
            PreparedStatement pstatement = connection.prepareStatement(sql);

            pstatement.setString(1, nom_joueur);
            pstatement.setString(2, prenom_joueur);
            ResultSet rs = pstatement.executeQuery();
            rs.next();
            count = rs.getInt(1);
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return count;
    }
    
  //Quel est le nom du club du joueur numero X ?
    public String getNameClubSQL(int no_joueur){
        String sql = ("SELECT nom_club FROM clubs NATURAL JOIN joueurs WHERE no_joueur = ? ");
        String nom_club = "";
        try {
            Connection connection = connect();
            PreparedStatement pstatement = connection.prepareStatement(sql);

            pstatement.setInt(1, no_joueur);
            ResultSet rs = pstatement.executeQuery();
            rs.next();
            nom_club = rs.getString("nom_club");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return nom_club;
    }

    
    //Est-ce que le club existe ?
    public boolean countClubSQL(String club) {
        String sql =("SELECT COUNT(*) FROM clubs WHERE nom_club = ?");
        int count = 0;
        try {
            Connection connection = connect();
            PreparedStatement pstatement = connection.prepareStatement(sql);

            pstatement.setString(1, club);
            ResultSet rs = pstatement.executeQuery();
            rs.next();
            count = rs.getInt(1);
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return count > 0;
    }

    //Quel est le numéro du club ?
    public int getNoClubSQL(String club) {
        String sql = ("SELECT no_club FROM clubs WHERE nom_club = ? ");
        int count = 0;
        try {
            Connection connection = connect();
            PreparedStatement pstatement = connection.prepareStatement(sql);
            pstatement.setString(1, club);
            ResultSet rs = pstatement.executeQuery();
            rs.next();
            count = rs.getInt(1);
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return count;
    }

    //Modifie le numero de club du joueur
    public int updateSQL(int no_nouveau_club,int no_joueur){
        String sql = ("UPDATE joueurs SET no_club = ? WHERE no_joueur = ?");
        int affectedrows = 0;
        try {
            Connection connection = connect();
            PreparedStatement pstatement = connection.prepareStatement(sql);
            pstatement.setInt(1, no_nouveau_club);
            pstatement.setInt(2, no_joueur );
            affectedrows = pstatement.executeUpdate();
        }catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return affectedrows;
    }
    
    //Insertion d'un nouveau transfert
    public int insertTransfertSQL(double montant, int no_joueur, int no_ancien_club, int no_nouveau_club){
    	
    	String sql = ("SELECT COUNT(*) FROM transferts");
    	int count = 0;
        int affectedrows = 0;

        try {
            Connection connection = connect();
            PreparedStatement pstatement = connection.prepareStatement(sql);
            ResultSet rs = pstatement.executeQuery();
            rs.next();
            count = rs.getInt(1);
            count = count +1;
    	
            sql = ("INSERT INTO transferts (no_transfert,montant,date_transfert,no_joueur,no_club_depart,no_club_arrivee) VALUES (? , ?, NOW(), ?, ?, ?)");
        	try {
            	connection = connect();
            	pstatement = connection.prepareStatement(sql);
            	pstatement.setDouble(1, count);
            	pstatement.setDouble(2, montant);
            	pstatement.setInt(3, no_joueur );
            	pstatement.setInt(4, no_ancien_club);
            	pstatement.setInt(5, no_nouveau_club);
            
            	affectedrows = pstatement.executeUpdate();
        	}catch (SQLException ex) {
            	System.out.println(ex.getMessage());
        	}
        
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    	return affectedrows;

    }
    
    
}

