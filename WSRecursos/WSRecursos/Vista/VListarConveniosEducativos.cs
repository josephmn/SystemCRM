using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarConveniosEducativos : BDconexion
    {
        public List<EListarConveniosEducativos> ListarConveniosEducativos(Int32 post, Int32 id)
        {
            List<EListarConveniosEducativos> lCListarConveniosEducativos = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarConveniosEducativos oVListarConveniosEducativos = new CListarConveniosEducativos();
                    lCListarConveniosEducativos = oVListarConveniosEducativos.ListarConveniosEducativos(con, post, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarConveniosEducativos);
        }
    }
}