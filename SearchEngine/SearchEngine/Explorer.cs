using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;
using Pohon;
using System.Diagnostics;

namespace SearchEngine
{
    class Explorer
    {

        private int countTotal { get; set; }
        private int countVisited { get; set; }        
        private string treeString { get; set; }
        public string getTreeString()
        {
        //mendapatkan string yang merupakan urutan folder/file yang ditelusuri
            return "[Tree]" + treeString + "[/Tree]";
        }
        private string keyword { get; set; }

        public Explorer(string path, string keyword, string type)
        {
        //Konstruktor explorer, memanggil MakeTree dan DFSPrint/BFSPrint
            treeString = "";
            this.keyword = keyword;
            countTotal = 0;
            countVisited = 0;
            TreeNode<string> root = new TreeNode<string>(path,"folder");
            root.SetParent(null) ;
            MakeTree(path,root);
            Stopwatch sw = Stopwatch.StartNew();
            if(type.CompareTo("DFS") == 0)
            {
                DFSSearch(root, 0);
            } else 
            {
                Queue<TreeNode<string>> queueBFS = new Queue<TreeNode<string>>();
                queueBFS.Enqueue(root);
                Queue<TreeNode<string>> queueChild = new Queue<TreeNode<string>>();
                BFSSearch(queueBFS, queueChild,0);
            }
            sw.Stop();
            Console.WriteLine("[Time]" + sw.ElapsedMilliseconds + "[/Time]");

        }
        
        public void MakeTree(string namafile, TreeNode<string> T)
        {
        //membentuk pohon status dari file dan direktori dari direktori tertentu
            if (Directory.Exists(namafile))
            {
                string[] listdirektori = {};
                try{
                    listdirektori = Directory.GetDirectories(namafile);
                } catch (Exception e){

                }
                if (listdirektori.Length > 0)
                {
                    foreach (var directori in listdirektori)
                    {
                        string dirr = directori;
                        TreeNode<string> nodee = T.AddChild(dirr,"folder");
                        countTotal++;
                        MakeTree(dirr, nodee);

                    }
                }
                string[] listfile={};
                try
                {
                    listfile = Directory.GetFiles(namafile);
                }
                catch (Exception e)
                {

                }
                if (listfile.Length > 0)
                {
                    foreach (var directori in listfile)
                    {
                        countTotal++;
                        string filee = directori;
                        TreeNode<string> nodef = T.AddChild(filee,"file");

                    }
                }
            }
        }

        private void Space(int n)
        {
        //mencetak spasi sebanyak n
            for (int i = 1; i <= n; i++)
            {
                treeString+=" ";
            }
        }

        private string getName(string s)
        {
        //mendapatkan nama file dari suatu string path
            int z = s.Length - 1;
            while((s.ElementAt(z) != '\\') && (z>0)){
                z--;
            }
            if (z == 0)
            {
                return null;
            }
            else
            {
                return s.Substring(z + 1);
            }
        }

        

        private void Search1(string path, string type)
        {
       //mengecek apakah suatu file/folder mengandung keyword yang ingin dicari
            string name = getName(path);
            if (type.CompareTo("folder") == 0)
            {
                bool nameMatch = false;
                int i = 0;
                while ((!nameMatch) && (i < name.Length))
                {
                    if (Search.isFound(i, name, keyword))
                    {
                        nameMatch = true;
                    }
                    i++;
                }
                if (nameMatch)
                {
                    Result r = new Result(name,path,name);
                    r.print();
                }

            }
            else //file
            {
                //get extension
                bool found = false;
                FileReader fr = new FileReader(path);
                string teks = fr.getText();
                string excerpt = null;
                Search.searchString(keyword, teks, ref found, ref excerpt);
                if (found)
                {
                    Result r = new Result(name, path, excerpt);
                    r.print();
                }
                else //not found, coba cari nama file
                {
                    bool nameMatch = false;
                    int i = 0;
                    while ((!nameMatch) && (i < name.Length))
                    {
                        if (Search.isFound(i, name, keyword))
                        {
                            nameMatch = true;
                        }
                        i++;
                    }
                    if (nameMatch)
                    {
                        Result r = new Result(name, path, name);
                        r.print();
                    }
                }
            }
        }

        private void DFSSearch(TreeNode<string> X,int y){
        //melakukan penelusuran secara DFS dan mencetak node yang dikunjungi
            Space(y);
            treeString+="Name = " + X.GetData() + " | Children = " + X.GetChildren().Count+"\n";
            if (X.GetParent() != null) countVisited++;
            Search1(X.GetData(), X.GetType());
            float progress = (float)countVisited / (float)countTotal;
            Console.WriteLine("[Progress]" + progress * 100 + "[/Progress]");
            foreach (var child in X.GetChildren())
            {
                int z = y + 7;
                DFSSearch(child, z);
            }
        }

        private void BFSSearch(Queue<TreeNode<string>> queue, Queue<TreeNode<string>> queueChild, int y)
        {
        //melakukan penelusuran secara BFS dan mencetak node yang dikunjungi
            TreeNode<string> t;
            t = queue.Peek();
            queue.Dequeue();
            Space(y);
            treeString += "Name = " + t.GetData() + " | Children = " + t.GetChildren().Count + "\n";
            if(t.GetParent()!=null)countVisited++;
            Search1(t.GetData(), t.GetType());
            float progress = (float)countVisited / (float)countTotal;
            Console.WriteLine("[Progress]" + progress * 100 + "[/Progress]");           

            foreach (var child in t.GetChildren())
            {
                queueChild.Enqueue(child);
            }

            if(!(queue.Count == 0)){
                BFSSearch(queue, queueChild, y);
            }
            else if ((!(queueChild.Count == 0)) && (queue.Count == 0))
            {
                Queue<TreeNode<string>> queue2 = new Queue<TreeNode<string>>(queueChild);                
                queueChild.Clear();
                BFSSearch(queue2, queueChild, y + 7);
            }              
        }       
    }
}
