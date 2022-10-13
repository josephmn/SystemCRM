using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarAsistentes : BDconexion
    {
        public List<EListarAsistentes> Listar_ListarAsistentes(String dni)
        {
            List<EListarAsistentes> lCListarAsistentes = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarAsistentes oVListarAsistentes = new CListarAsistentes();
                    lCListarAsistentes = oVListarAsistentes.Listar_ListarAsistentes(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarAsistentes);
        }
    }
}