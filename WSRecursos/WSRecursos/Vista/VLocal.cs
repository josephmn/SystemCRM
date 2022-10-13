using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VLocal : BDconexion
    {
        public List<ELocal> Listar_Local(Int32 id, Int32 zona)
        {
            List<ELocal> lCLocal = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CLocal oVLocal = new CLocal();
                    lCLocal = oVLocal.Listar_Local(con, id, zona);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCLocal);
        }
    }
}