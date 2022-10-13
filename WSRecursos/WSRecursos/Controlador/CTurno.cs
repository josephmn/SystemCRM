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
    public class CTurno
    {
        public List<ETurno> Listar_Turno(SqlConnection con, Int32 id, Int32 turno)
        {
            List<ETurno> lETurno = null;
            SqlCommand cmd = new SqlCommand("ASP_TURNO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlParameter par1 = cmd.Parameters.Add("@id", SqlDbType.Int);
            par1.Direction = ParameterDirection.Input;
            par1.Value = id;

            SqlParameter par2 = cmd.Parameters.Add("@turno", SqlDbType.Int);
            par2.Direction = ParameterDirection.Input;
            par2.Value = turno;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lETurno = new List<ETurno>();

                ETurno obETurno = null;
                while (drd.Read())
                {
                    obETurno = new ETurno();
                    obETurno.i_id = drd["i_id"].ToString();
                    obETurno.i_num_semana = drd["i_num_semana"].ToString();
                    obETurno.v_descripcion = drd["v_descripcion"].ToString();
                    obETurno.id_local = drd["id_local"].ToString();
                    obETurno.v_local = drd["v_local"].ToString();
                    obETurno.i_anhio = drd["i_anhio"].ToString();
                    obETurno.i_dias = drd["i_dias"].ToString();
                    lETurno.Add(obETurno);
                }
                drd.Close();
            }

            return (lETurno);
        }
    }
}