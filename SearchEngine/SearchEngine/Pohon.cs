using System;
using System.Text;
using System.Collections.Generic;
using System.IO;


namespace Pohon
{
    delegate void TreeVisitor<T>(T nodeData);

    public class TreeNode<T>
    {
        
        private T Data { get; set; }
        private string Type { get; set; }
        private TreeNode<T> Parent { get; set; }
        private ICollection<TreeNode<T>> Children { get; set; }

        public T GetData()
        {//Mengembalikan Data pada suatu node
            return this.Data;
        }

        public void setData(T Data)
        {//Mengeset Data pada suatu node
            this.Data = Data;
        }

        public string GetType()
        {//Mengembalikan Type suatu node
            return this.Type;
        }

        public void setType(string type)
        {//Mengeset Type suatu node
            this.Type = Type;
        }


        public TreeNode<T> GetParent()
        {//Mengembalikan Parent suatu node
            return this.Parent;
        }

        public void SetParent(TreeNode<T> Parent)
        {//Mengeset Parent suatu node
            this.Parent = Parent;
        }

        public ICollection<TreeNode<T>> GetChildren()
        {//Mengembalikan Children suatu node
            return this.Children;
        }

        public void SetChildren(ICollection<TreeNode<T>> Children)
        {//Mengeset Child suatu node
            this.Children = Children;
        }

        public TreeNode(T data, string type)
        {//Constructor TreeNode
            this.Data = data;
            this.Type = type;
            this.Children = new LinkedList<TreeNode<T>>();
        }

        public TreeNode<T> AddChild(T child,string type)
        {//Menambahkan Child pada suatu Node
            TreeNode<T> childNode = new TreeNode<T>(child,type) { Parent = this };
            this.Children.Add(childNode);
            return childNode;
        }        
    }
}
