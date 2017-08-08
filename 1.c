(client server thread)
Server.java

import java.io.*; 
import java.net.*; 
public class Server { 
public static void main(String args[]) { 
int port = 6789; 
Server server = new Server( port ); 
server.startServer(); 
} 
// declare a server socket and a client socket for the server; 
// declare the number of connections 
ServerSocket echoServer = null; 
Socket clientSocket = null; 
int numConnections = 0; 
int port; 
public Server( int port ) { 
this.port = port; 
} 
public void stopServer() { 
System.out.println( "Server cleaning up." ); 
System.exit(0); 
} 
public void startServer() { 
// Try to open a server socket on the given port 
// Note that we can't choose a port less than 1024 if we are not 
// privileged users (root) 
try { 
echoServer = new ServerSocket(port); 
} 
catch (IOException e) { 
System.out.println(e); 
} 
System.out.println( "Server is started and is waiting for connections." 
); 
System.out.println( "With multi-threading, multiple connections allowed." ); 
System.out.println( "Any client can send -1 to stop the server." ); 
//are 
// Whenever a connection is received, start a new thread to process the 
//connection 
// and wait for the next connection. 
while ( true ) { 
try { 
clientSocket = echoServer.accept();numConnections ++; 
ServerConnection oneconnection = new ServerConnection(clientSocket, 
numConnections, this); 
new Thread(oneconnection).start(); 
} 
catch (IOException e) { 
System.out.println(e); 
} 
} 
} 
} 
class ServerConnection implements Runnable { 
BufferedReader is; 
PrintStream os; 
Socket clientSocket; 
int id; 
Server server; 
public ServerConnection(Socket clientSocket, int id, Server server) { 
this.clientSocket = clientSocket; 
this.id = id; 
this.server = server; 
System.out.println( "Connection " + id + " established with: " + 
clientSocket ); 
try { 
is 
= 
new 
BufferedReader(new 
InputStreamReader(clientSocket.getInputStream())); 
os = new PrintStream(clientSocket.getOutputStream()); 
} catch (IOException e) { 
System.out.println(e); 
} 
} 
public void run() { 
String line; 
try { 
boolean serverStop = false; 
while (true) { 
line = is.readLine(); 
System.out.println( "Received " + line + " from Connection " + id + 
"." ); 
int n = Integer.parseInt(line); 
if ( n == -1 ) { 
serverStop = true; 
break; 
} 
if ( n == 0 ) break; 
os.println("" + n*n ); 
} 
System.out.println( "Connection " + id + " closed." ); 
is.close(); 
os.close(); 
clientSocket.close(); 
if ( serverStop ) server.stopServer(); 
} catch (IOException e) {System.out.println(e); 
} 
} 
}

//Client.java

import java.io.*; 
import java.net.*; 
public class Client { 
public static void main(String[] args) { 
String hostname = "172.16.2.225"; 
int port = 6789; 

Socket clientSocket = null; 
DataOutputStream os = null; 
BufferedReader is = null; 
// Initialization section: 
// Try to open a socket on the given port 
// Try to open input and output streams 
try { 
clientSocket = new Socket(hostname, port); 
os = new DataOutputStream(clientSocket.getOutputStream()); 
is 
= 
new 
BufferedReader(new 
InputStreamReader(clientSocket.getInputStream())); 
} catch (UnknownHostException e) { 
System.err.println("Don't know about host: " + hostname); 
} catch (IOException e) { 
System.err.println("Couldn't get I/O for the connection to: " + hostname); 
} 
// If everything has been initialized then we want to write some data 
// to the socket we have opened a connection to on the given port 
if (clientSocket == null || os == null || is == null) { 
System.err.println( "Something is wrong. One variable is null." ); 
return; 
} 
try { 
while ( true ) { 
System.out.print( "Enter an integer (0 to stop connection, -1 to stop server): " ); 
BufferedReader br = new BufferedReader(new InputStreamReader(System.in)); 
String keyboardInput = br.readLine(); 
os.writeBytes( keyboardInput + "\n" );int n = Integer.parseInt( keyboardInput ); 
if ( n == 0 || n == -1 ) { 
break; 
} 
String responseLine = is.readLine(); 
System.out.println("Server returns its square as: " + responseLine); 
} 

os.close(); 
is.close(); 
clientSocket.close(); 
} catch (UnknownHostException e) { 
System.err.println("Trying to connect to unknown host: " + e); 
} catch (IOException e) { 
System.err.println("IOException: " + e); 
} 
} 
}

//OUTPUT :

sitrc@sitrc-OptiPlex-380:~$ javac Client.java 
sitrc@sitrc-OptiPlex-380:~$ java Client 
Enter an integer (0 to stop connection, -1 to stop server): 8 
Server returns its square as: 64 
Enter an integer (0 to stop connection, -1 to stop server): 6 
Server returns its square as: 36 
Enter an integer (0 to stop connection, -1 to stop server): 5 
Server returns its square as: 25 
Enter an integer (0 to stop connection, -1 to stop server): 0 
sitrc@sitrc-OptiPlex-380:~$ 


sitrc@sitrc-OptiPlex-380:~$ javac Server.java 
sitrc@sitrc-OptiPlex-380:~$ java Server 
Server is started and is waiting for connections. 
With multi-threading, multiple connections allowed. 
Any client can send -1 to stop the server. 
Connection 1 established with: Socket[addr=/172.16.2.225,port=60910,localport=6789] 
Connection 2 established with: Socket[addr=/172.16.2.225,port=60911,localport=6789] 
Received 8 from Connection 1. 
Received 6 from Connection 1. 
Received 5 from Connection 1. 
Received 0 from Connection 1. 
