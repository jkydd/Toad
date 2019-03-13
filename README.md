
# Toad++ 
 
### Introduction
*Toad++* is an online visualization tool for toad data. The software allows users to produce and recognize significant differences or patterns, especially among blinded frogs and non-blinded frogs, that is not obvious to the naked eye. The software allows the user to control and combine different parameters such as a number of frogs and jumps to help narrow down the search for patterns and trends.

### General Description 
The toad data currently consist of 3 main datasets: 
1. Timing variables: from video recorded of toads hopping (i.e. when the hop started, when the toad landed, etc).  
2. 3D movement data:  (x,y,z coordinates) for specific points of interest on each toad  (aka, kinematic data).  
3. 3D force data: tells the amount of force in the normal (vertical), fore-aft (front-back), and lateral (side-to-side) directions that are exerted when a toad lands.

The software allows users to upload their own data. When the user generates the visualization for the data, there are three different graphs displayed. The first graph is the jump of the frog using 3D movement data. This allows the user to see the position of the frog in the air over time. The user can also hover on the graph to see the exact X and Y position of the frog at a particular time. 

The second graph on the page is a radar chart. This radar chart shows the Elbow Flexion/Extension Angle, Humeral Elevation/Depression Angle, and Humeral Protraction Angle. The radar chart will match the timestamp of the first graph, meaning the radar chart will reflect whichever phase of the jump the frog is on. The change in angle during the jump is shown through the animation of the radar graph as the frog progresses through its jumping phase.
The third graph is a bar graph of the force plate data. The force plate data displays the force exerted when the frog initially jumps and the force exerted when the frog lands. This force plate data is matched and adjusted accordingly to the first graph of the frog jump.  

