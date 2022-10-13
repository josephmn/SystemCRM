using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarJefes : BDconexion
    {
        public List<EListarJefes> Listar_ListarJefes()
        {
            List<EListarJefes> lCListarJefes = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarJefes oVListarJefes = new CListarJefes();
                    lCListarJefes = oVListarJefes.Listar_ListarJefes(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarJefes);
        }
    }
}