using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CDistrito
    {
        public List<EDistrito> Listar_Distrito(SqlConnection con, Int32 provincia)
        {
            List<EDistrito> lEDistrito = null;
            SqlCommand cmd = new SqlCommand("ASP_DISTRITO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@provincia", SqlDbType.Int);
            par1.Direction = ParameterDirection.Input;
            par1.Value = provincia;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEDistrito = new List<EDistrito>();

                EDistrito obEDistrito = null;
                while (drd.Read())
                {
                    obEDistrito = new EDistrito();
                    obEDistrito.i_iddis = drd["i_iddis"].ToString();
                    obEDistrito.v_descripcion = drd["v_descripcion"].ToString();
                    lEDistrito.Add(obEDistrito);
                }
                drd.Close();
            }

            return (lEDistrito);
        }
    }
}