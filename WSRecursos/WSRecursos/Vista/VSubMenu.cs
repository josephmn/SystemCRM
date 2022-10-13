using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VSubMenu : BDconexion
    {
        public List<ESubMenu> SubMenu(Int32 dato)
        {
            List<ESubMenu> lCSubMenu = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CSubMenu oVSubMenu = new CSubMenu();
                    lCSubMenu = oVSubMenu.Listar_SubMenu(con, dato);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCSubMenu);
        }
    }
}